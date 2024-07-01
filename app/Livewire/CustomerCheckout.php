<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Status;
use Livewire\Component;
use App\Models\WithPpnOrder;
use Illuminate\Support\Facades\Crypt;

class CustomerCheckout extends Component
{
    public $order_status;
    public $order_code;
    public $order;
    public $order_detail;
    public $menus;

    public function mount($order_code){
        $this->order_code = $order_code;

        if(isset($_COOKIE['order_codes'])) {
            $order_codes = Crypt::decrypt($_COOKIE['order_codes']);
            if (in_array($order_code, $order_codes)) {
                $this->order = WithPpnOrder::where('order_code', '=', $order_code)->get()->toArray()[0];
                $this->order_detail = Order::select('id','customer_name','status_id','order_time','table_number')->where('order_code', '=', $order_code)->first();
                $this->menus = Order::with('menu')->select('menu_id','qty','total_price')->where('order_code', '=', $order_code)->get();
                $this->order_status = Status::find($this->order['status_id'])->toArray()['status'];
            }else {
                return redirect()->route('customer_order');
            }
        } else {
            return redirect()->route('customer_order');
        }
    }

    public function updateStatus(){
        Order::where('order_code', '=', $this->order_code)->update(['status_id' => 2]);
        WithPpnOrder::where('order_code', '=', $this->order_code)->update(['status_id' => 2]);
        return redirect()->route('checkout', ['order_code' => $this->order_code]);
    }
    
    public function render()
    {
        return view('livewire.customer-checkout');
    }
}
