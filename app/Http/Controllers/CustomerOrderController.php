<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\WithPpnOrder;

class CustomerOrderController extends Controller
{
    public function index(){
        return view('customer-order');
    }

    public function checkout($order_code){
        return view('customer-checkout', [
            "order" => WithPpnOrder::where('order_code', '=', $order_code)->get()->toArray()[0],
            "order_detail" => Order::select('id','customer_name','status_id','order_time','table_number')->where('order_code', '=', $order_code)->first(),
            "menus" => Order::with('menu')->select('menu_id','qty','total_price')->where('order_code', '=', $order_code)->get()
        ]);
    }
}
