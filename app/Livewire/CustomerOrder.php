<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Crypt;
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
    public $selected_menu = [];
    public $total_price;
    public $ppn;
    public $total_price_with_ppn;
    public $total = 0;

    public function updateCart(){
        foreach ($this->menu_id as $key => $value) {
            if ($value == "") {
                $this->dispatch(
                    'uncheckboxes',
                    id: $key
                );
                unset($this->menu_id[$key]);
                unset($this->selected_menu[$key]);
            }
        }

        if ($this->menu_id) {
            $total = 0;
            foreach ($this->menu_id as $menuId => $qty) {
                $price = Menu::select('price')->where('id', $menuId)->get()->toArray()[0]["price"];
                $total = $total + $price * $qty;
                $this->selected_menu[$menuId] = Menu::where('id','=',$menuId)->get()->toArray()[0];
            }
            $ppn = Ppn::find(1)->get()->toArray()[0]["ppn"];
            $this->total = $total + ($total * $ppn / 100);
        }else {
            $this->total = 0;
        }
    }

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
            'customer_name' => 'required|max:35',
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

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $total_price_for_ppn + ($total_price_for_ppn * $ppn / 100),
            ),
            'customer_details' => array(
                'first_name' => $this->customer_name,
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        WithPpnOrder::create([
            'order_code' => $this->order_code,
            'snap_token' => $snapToken,
            'total_price' => $total_price_for_ppn,
            'ppn' => $ppn.'%',
            'total_price_with_ppn' => $total_price_for_ppn + ($total_price_for_ppn * $ppn / 100),
            'status_id' => 1,
        ]);

        // $this->dispatch('resetCheckBoxes', menus: $this->menu_id);

        // $this->rset();

        $this->dispatch(
            'sweetalert',
            icon: 'success',
            title: 'Pesanan Berhasil Ditambahkan',
            position: 'top'
        );

        if(isset($_COOKIE['order_codes'])) {
            $order_codes = Crypt::decrypt($_COOKIE['order_codes']);
        } else {
            $order_codes = [];
        }

        $order_codes[] = $this->order_code;
        $order_codes = Crypt::encrypt($order_codes);
        // time() + (24 * 60 * 60) to get 1 day time for the cookie expiration
        $expired_time = time() + (24 * 60 * 60);
        // "/" means the cookie can be access at all pages
        setcookie("order_codes", $order_codes, $expired_time, "/");
        
        return redirect()->route('checkout', ['order_code' => $this->order_code]);
    }

    public function render()
    {
        return view('livewire.customer-order', [
            'menus' => Menu::where('menu', "like", "%{$this->search}%")->orWhere('price', 'like', "%{$this->search}%")->get(),
        ]);
    }
}
