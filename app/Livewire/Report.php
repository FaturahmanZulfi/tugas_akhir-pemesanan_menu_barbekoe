<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReportController;

class Report extends Component
{   
    use WithPagination;
    
    public $total;
    public $time;
    public $order_years;
    public $selected_year="";
    public $order_months=[];
    public $selected_month="";
    public $order_days=[];
    public $selected_day="";
    public $orders;
    public $search;

    public function excel(){
        $orders = DB::select("SELECT * FROM (SELECT with_ppn_orders.id, with_ppn_orders.order_code, with_ppn_orders.total_price_with_ppn, with_ppn_orders.status_id, orders.customer_name, SUBSTRING(orders.order_time, 1, 10) as order_time FROM with_ppn_orders INNER JOIN orders ON with_ppn_orders.order_code = orders.order_code) AS orders GROUP BY order_code");
        session(['orders' => $orders]);
        return redirect()->action([ReportController::class, 'excel']);
    }

    public function render()
    {
        $this->time="";
        $this->order_years = DB::select("SELECT SUBSTRING(order_time, 1, 4) as year FROM orders GROUP BY year");
        if($this->selected_year){
            $this->order_months = DB::select("SELECT SUBSTRING(order_time, 1, 7) as month FROM orders WHERE order_time LIKE '{$this->selected_year}%' GROUP BY month");
            $this->time = $this->selected_year;
            if($this->selected_month){
                $this->order_days = DB::select("SELECT SUBSTRING(order_time, 1, 10) as day FROM orders WHERE order_time LIKE '{$this->selected_month}%' GROUP BY day");
                $this->time = $this->selected_month;

                if (substr($this->selected_day, 0,7) != $this->selected_month) {
                    $this->selected_day ="";
                }
                
                if($this->selected_day){
                    $this->time = $this->selected_day;
                }

            }else {
                $this->selected_day ="";
                $this->order_days=[];
            }

            if (substr($this->selected_month, 0,4) != $this->selected_year) {
                $this->selected_month ="";
            }
        }else {
            $this->selected_month ="";
            $this->selected_day ="";
            $this->order_months =[];
            $this->order_days=[];
            $this->time = "";
        }
        
        $this->orders = DB::select("SELECT * FROM (SELECT * FROM (SELECT with_ppn_orders.id, with_ppn_orders.order_code, with_ppn_orders.total_price_with_ppn, with_ppn_orders.status_id, orders.customer_name, orders.order_time FROM with_ppn_orders INNER JOIN orders ON with_ppn_orders.order_code = orders.order_code) AS orders WHERE order_time LIKE '{$this->time}%' GROUP BY order_code) as orders WHERE customer_name LIKE '{$this->search}%'");
        $this->total = DB::select("SELECT SUM(total_price_with_ppn) as total FROM (SELECT * FROM (SELECT * FROM (SELECT with_ppn_orders.id, with_ppn_orders.order_code, with_ppn_orders.total_price_with_ppn, with_ppn_orders.status_id, orders.customer_name, orders.order_time FROM with_ppn_orders INNER JOIN orders ON with_ppn_orders.order_code = orders.order_code) AS orders WHERE order_time LIKE '{$this->time}%' GROUP BY order_code) as orders WHERE customer_name LIKE '{$this->search}%') as orders");
        return view('livewire.report');
    }
}
