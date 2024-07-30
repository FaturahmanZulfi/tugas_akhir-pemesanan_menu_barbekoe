<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\WithPpnOrder;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request){
        $serverKey = config('midtrans.serverKey');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == "settlement") {
                Order::where('order_code', '=', $request->order_id)->update(['status_id' => 2]);
                WithPpnOrder::where('order_code', '=', $request->order_id)->update(['status_id' => 2]);
            }
        }
    }
}
