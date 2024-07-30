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

    public function generatePdf(){
        $order_status = session('order_status');
        $order = session('order');
        $order_detail = session('order_detail');
        $menus = session('menus');

        $mpdf = new \Mpdf\Mpdf(['format' => [120, 236]]);
        $mpdf->WriteHTML(
            view('pdf', [
                "order_status" => $order_status,
                "order" => $order,
                "order_detail" => $order_detail,
                "menus" => $menus
            ])
        );

        $mpdf->Output('Struk-Belanja-BarbeKoe.pdf','D');
    }
}
