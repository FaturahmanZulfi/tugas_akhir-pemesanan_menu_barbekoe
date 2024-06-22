<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cookie;
use App\Models\Menu;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\Ppn;
use App\Models\WithPpnOrder;
use Carbon\Carbon;

class CustomerOrder extends Component
{
    public $perPage = 5;
    public $search = '';

    public $new_ppn;

    public $order_code;
    public $customer_name;
    public $table_number;
    public $menu_id = [];
    public $total_price;
    public $ppn;
    public $total_price_with_ppn;

    public function incrementQty($menuId){
        $this->menu_id[$menuId] = '1';
    }

    public function decrementQty($menuId){
        $this->menu_id[$menuId] = '';
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
            'customer_name' => 'required',
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
                'status_id' => 1,
                'user_id' => 0,
                'order_time' => $now
            ]);
            $newStock = $stock - $qty;
            Menu::find($menuId)->update(['stock' => $newStock]);
        }

        WithPpnOrder::create([
            'order_code' => $this->order_code,
            'total_price' => $total_price_for_ppn,
            'ppn' => $ppn.'%',
            'total_price_with_ppn' => $total_price_for_ppn + ($total_price_for_ppn * $ppn / 100)
        ]);

        $this->dispatch('resetCheckBoxes', menus: $this->menu_id);

        // $this->rset();

        $this->dispatch(
            'sweetalert',
            icon: 'success',
            title: 'Pesanan Berhasil Ditambahkan',
            position: 'top'
        );

        Cookie::queue(Cookie::make('order_code', $this->order_code, 120));

        return redirect()->route('checkout', ['order_code' => $this->order_code]);
    }

    public function render()
    {
        return view('livewire.customer-order', [
            'menus' => Menu::where('menu', "like", "%{$this->search}%")->orWhere('price', 'like', "%{$this->search}%")->get(),
        ]);
    }
}
