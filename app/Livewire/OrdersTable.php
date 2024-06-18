<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\User;
use App\Models\Status;
use App\Models\Menu;
use Carbon\Carbon;

class OrdersTable extends Component
{
    use WithPagination;
    
    public $perPage = 5;
    public $search = '';

    public $order_code;
    public $customer_name;
    public $table_number;
    public $menu_id = [];
    public $status_id = 1;
    public $total_price;

    public function incrementQty($menuId){
        $this->menu_id[$menuId] = '1';
    }

    public function decrementQty($menuId){
        $this->menu_id[$menuId] = '';
    }

    public function rset(){
        $this->reset(['order_code', 'customer_name', 'table_number', 'menu_id', 'status_id', 'total_price']);
        $this->resetValidation();
    }

    public function createNewOrder(){
        $now = Carbon::now();
        $milisecond = substr($now->format('u'), 0, 3);
        $this->order_code = $now->format('YmdHis') . $milisecond . "BK";

        // dump($this->menu_id);
        foreach ($this->menu_id as $key => $value) {
            if ($value == "") {
                unset($this->menu_id[$key]);
            }
        }
        // dump($this->menu_id);
        
        $validated = $this->validate([
            'customer_name' => 'required',
            'table_number' => 'required',
            'menu_id' => 'required'
        ]);

        foreach ($this->menu_id as $menuId => $qty) {
            $price = Menu::select('price')->where('id', $menuId)->get()->toArray()[0]["price"];
            $stock = Menu::select('stock')->where('id', $menuId)->get()->toArray()[0]["stock"];
            $total_price = $price * $qty;
            Order::create([
                'order_code' => $this->order_code,
                'customer_name' => $this->customer_name,
                'menu_id' => $menuId,
                'qty' => $qty,
                'total_price' => $total_price,
                'table_number' => $this->table_number,
                'status_id' => $this->status_id,
                'user_id' => 0,
                'order_time' => $now
            ]);
            $newStock = $stock - $qty;
            Menu::find($menuId)->update(['stock' => $newStock]);
        }

        $this->dispatch('resetCheckBoxes', menus: $this->menu_id);

        $this->rset();

        $this->dispatch(
            'sweetalert',
            icon: 'success',
            title: 'Pesanan Berhasil Ditambahkan',
            position: 'top'
        );
    }

    public function getOrder($order_code){
        $this->rset();
        $this->dispatch('resetCheckBoxes', menus: $this->menu_id);
        $order = Order::where('order_code', '=', $order_code)->first()->toArray();
        $menus = Order::select('menu_id','qty')->where('order_code', '=', $order_code)->get()->toArray();

        $this->order_code = $order_code;
        $this->customer_name = $order["customer_name"];
        $this->table_number = $order["table_number"];
        $this->status_id = $order["status_id"];

        foreach($menus as $menu){
            $this->menu_id[$menu['menu_id']] = $menu['qty'];
        }
        
        $total = Order::select(DB::raw('SUM(total_price) as total_price'))->where('order_code', '=', "{$order_code}")->get()->toArray()[0]["total_price"];
        $this->total_price=$total;
    }

    public function deleteOrder(){
        Order::where('order_code', '=', $this->order_code)->delete();

        $this->dispatch(
            'sweetalert',
            icon: 'error',
            title: 'Pesanan Berhasil Dihapus',
            position: 'top'
        );

        $this->dispatch(
            'closeoffcanvas',
            offcanvas: 'deleteOrder'
        );
    }

    public function updateOrder(){
        Order::where('order_code', '=', $this->order_code)->update(['status_id' => "{$this->status_id}"]);

        $this->dispatch(
            'sweetalert',
            icon: 'warning',
            title: 'Pesanan Berhasil Diubah',
            position: 'top'
        );
    }

    // public function deleteUser(){
    //     User::find($this->user_id)->delete();

    //     $this->rset();
    //     $this->reset('user_id');

    //     $this->dispatch(
    //         'sweetalert',
    //         icon: 'error',
    //         title: 'Data User Berhasil Dihapus',
    //         position: 'top'
    //     );

    //     $this->dispatch(
    //         'closeoffcanvas',
    //         offcanvas: 'deleteUser'
    //     );
    // }

    // public function updateUser(){
    //     if ($this->password == "") {
    //         $this->password = User::find($this->user_id)->password;
    //     }

    //     if($this->username == $this->old_username){
    //         $validated = $this->validate([
    //             'username' => '',
    //             'password' => 'required',
    //             'level_id' => 'required'
    //         ]);
    //     }else {
    //         $validated = $this->validate([
    //             'username' => 'required',
    //             'password' => 'required',
    //             'level_id' => 'required'
    //         ]);
    //     }

    //     User::find($this->user_id)->update($validated);

    //     $this->reset('password');

    //     $this->dispatch(
    //         'sweetalert',
    //         icon: 'warning',
    //         title: 'Data User Berhasil Diubah',
    //         position: 'top'
    //     );
    // }
    
    public function render()
    {   
        return view('livewire.orders-table', [
            'orders' => Order::select(['id','order_code', 'status_id', 'order_time','customer_name', 'table_number', DB::raw('SUM(total_price) as total_price')])->where('order_code','like', "%{$this->search}%")->orWhere('customer_name','like',"%{$this->search}%")->orWhere('table_number','like',"%{$this->search}%")->orWhere('order_time','like',"%{$this->search}%")->orWhereRelation('status','status','like',"%{$this->search}%")->groupBy('order_code')->orderBy('order_time','desc')->paginate($this->perPage),
            'menus' => Menu::where('stock','>',0)->get(),
            'statuses' => Status::all()
        ]);
    }
}
