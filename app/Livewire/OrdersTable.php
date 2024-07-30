<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Ppn;
use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use Livewire\Component;
use App\Models\WithPpnOrder;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdersTable extends Component
{
    use WithPagination;
    
    public $perPage = 5;
    public $search = '';

    public $new_ppn;

    public $order_code;
    public $customer_name;
    public $table_number;
    public $menu_id = [];
    public $status_id = 1;
    public $total_price;
    public $ppn;
    public $total_price_with_ppn;

    public $user_id;

    public function mount(){
        $this->user_id = Auth::user()->id;
    }

    public function getPpn(){
        $this->ppn = Ppn::find(1)->get()->toArray()[0]["ppn"];
    }

    public function updatePpn(){
        $validated = $this->validate([
            'ppn' => 'required|numeric|max:99'
        ]);

        Ppn::find(1)->update($validated);

        $this->dispatch(
            'sweetalert',
            icon: 'success',
            title: 'Berhasil Ubah Ppn',
            position: 'top'
        );
    }

    public function incrementQty($menuId){
        $this->menu_id[$menuId] = '1';
    }

    public function decrementQty($menuId){
        $this->menu_id[$menuId] = '';
    }

    public function rset(){
        $this->reset(['order_code', 'customer_name', 'table_number', 'menu_id', 'status_id', 'total_price', 'ppn', 'total_price_with_ppn']);
        $this->resetValidation();
    }

    public function createNewOrder(){
        $ppn = Ppn::find(1)->get()->toArray()[0]["ppn"];

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
            'customer_name' => 'required|max:25',
            'table_number' => 'required',
            'menu_id' => 'required'
        ]);

        $total_price_for_ppn = 0;

        foreach ($this->menu_id as $menuId => $qty) {
            $price = Menu::select('price')->where('id', $menuId)->get()->toArray()[0]["price"];
            $stock = Menu::select('stock')->where('id', $menuId)->get()->toArray()[0]["stock"];
            $total_price = $price * $qty;
            $total_price_for_ppn += $total_price;
            Order::create([
                'order_code' => $this->order_code,
                'customer_name' => $this->customer_name,
                'menu_id' => $menuId,
                'qty' => $qty,
                'total_price' => $total_price,
                'table_number' => $this->table_number,
                'status_id' => $this->status_id,
                'user_id' => $this->user_id,
                'order_time' => $now
            ]);
            $newStock = $stock - $qty;
            Menu::find($menuId)->update(['stock' => $newStock]);
        }

        WithPpnOrder::create([
            'order_code' => $this->order_code,
            'total_price' => $total_price_for_ppn,
            'ppn' => $ppn.'%',
            'total_price_with_ppn' => $total_price_for_ppn + ($total_price_for_ppn * $ppn / 100),
            'status_id' => $this->status_id,
        ]);

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
        
        $total = WithPpnOrder::select('total_price', 'ppn', 'total_price_with_ppn')->where('order_code', '=', "{$order_code}")->get()->toArray()[0];
        $this->total_price=$total["total_price"];
        $this->ppn=$total["ppn"];
        $this->total_price_with_ppn=$total["total_price_with_ppn"];
    }

    public function deleteOrder(){
        foreach ($this->menu_id as $id => $qty) {
            $stock = Menu::select('stock')->where('id', '=', $id)->get()->toArray()[0]["stock"];
            $stock = $stock + $qty;
            
            Menu::find($id)->update(['stock' => $stock]);
        }
        
        Order::where('order_code', '=', $this->order_code)->delete();
        WithPpnOrder::where('order_code', '=', $this->order_code)->delete();
        
        $this->dispatch(
            'closeoffcanvas',
            offcanvas: 'deleteOrder'
        );

        $this->dispatch(
            'sweetalert',
            icon: 'error',
            title: 'Pesanan Berhasil Dihapus',
            position: 'top'
        );
    }

    public function updateOrder(){
        Order::where('order_code', '=', $this->order_code)->update(['status_id' => "{$this->status_id}"]);
        WithPpnOrder::where('order_code', '=', $this->order_code)->update(['status_id' => "{$this->status_id}"]);

        $this->dispatch(
            'sweetalert',
            icon: 'warning',
            title: 'Pesanan Berhasil Diubah',
            position: 'top'
        );
    }
    
    public function render()
    {   
        return view('livewire.orders-table', [
            'orders' => Order::select(['id','order_code', 'status_id', 'order_time','customer_name', 'table_number', DB::raw('SUM(total_price) as total_price')])->where('order_code','like', "%{$this->search}%")->orWhere('customer_name','like',"%{$this->search}%")->orWhere('table_number','like',"%{$this->search}%")->orWhere('order_time','like',"%{$this->search}%")->orWhereRelation('status','status','like',"%{$this->search}%")->groupBy('order_code')->orderBy('order_time','desc')->paginate($this->perPage),
            'menus' => Menu::all(),
            'used_ppn' => Ppn::find(1)->get()->toArray()[0]["ppn"],
            'statuses' => Status::all()
        ]);
    }
}
