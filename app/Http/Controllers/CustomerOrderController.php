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
            "order_code" => $order_code
        ]);
    }

    public function showOrderList(){
        return view('customer-order-list');
    }

    public function scan(){
        return view('customer-scan');
    }
}
