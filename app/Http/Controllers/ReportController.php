<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(){
        return view('report',[
            "active" => "report"
        ]);
    }
    
    public function excel(){
        $orders = session('orders');
        return view('excel', [
            "orders" => $orders
        ]);
    }
}
