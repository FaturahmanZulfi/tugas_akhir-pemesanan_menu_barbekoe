<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\WithPpnOrder;
use Illuminate\Support\Facades\Crypt;

class CustomerOrderList extends Component
{
    public $orders = [];
    public $orders_detail = [];

    public function mount(){
        if(!isset($_COOKIE['has_user_scan'])) {
            return redirect()->route('scan');
        }
        
        if(isset($_COOKIE['order_codes'])) {
            $order_codes = Crypt::decrypt($_COOKIE['order_codes']);
            foreach ($order_codes as $order_code) {
                $this->orders[] = WithPpnOrder::where('order_code', '=', $order_code)->get()->toArray()[0];
                $this->orders_detail[] = Order::select('customer_name','status_id','order_time')->where('order_code', '=', $order_code)->first();
            }
            // dump($this->orders);
            // dump($this->orders_detail);
        }
    }

    public function render()
    {
        return view('livewire.customer-order-list');
    }
}
