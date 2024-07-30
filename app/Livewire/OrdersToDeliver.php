<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WithPpnOrder;
use Illuminate\Support\Facades\DB;

class OrdersToDeliver extends Component
{
    public $customer;
    public $order_code;
    public $menus = [];

    public $category = "makanan";

    public function changeCategory($category){
        $this->category = $category;
    }

    public function getOrder($order_code){
        $this->order_code = $order_code;

        $this->menus = DB::select("SELECT menu,qty FROM (SELECT orders.order_code, orders.customer_name, orders.order_time, orders.status_id, menus.menu, orders.qty, categories.category FROM orders INNER JOIN menus ON orders.menu_id = menus.id INNER JOIN categories ON menus.category_id = categories.id) AS orders WHERE category = '{$this->category}' AND status_id = 3 AND order_code = '{$order_code}' ORDER BY order_time ASC");
        $this->customer = DB::select("SELECT customer_name, order_time, table_number FROM orders WHERE order_code = '$order_code'")[0];
    }

    public function updateStatus(){
        DB::update("UPDATE orders SET status_id = 4 WHERE id IN (SELECT id FROM (SELECT orders.id FROM orders INNER JOIN menus ON orders.menu_id = menus.id INNER JOIN categories ON menus.category_id = categories.id WHERE categories.category = '{$this->category}' AND orders.order_code = '{$this->order_code}') as orders)");

        $all= DB::select("SELECT * FROM (SELECT orders.id, orders.order_code, orders.customer_name, menus.menu, orders.status_id FROM orders INNER JOIN menus ON orders.menu_id = menus.id INNER JOIN categories ON menus.category_id = categories.id WHERE orders.order_code = '{$this->order_code}') AS orders WHERE status_id = 3");

        if (empty($all)) {
            WithPpnOrder::where('order_code', '=' ,$this->order_code)->update(['status_id' => 4]);
        }

        $this->dispatch(
            'closeoffcanvas',
            offcanvas: 'detailOffcanvas'
        );

        $this->dispatch(
            'sweetalert',
            icon: 'success',
            title: 'Pesanan Sudah Diantar',
            position: 'top'
        );
    }
    
    public function render()
    {
        return view('livewire.orders-to-deliver', [
            "orders" => DB::select("SELECT * FROM (SELECT orders.order_code, orders.table_number, orders.customer_name, orders.order_time, orders.status_id, statuses.status, menus.menu, categories.category FROM orders INNER JOIN statuses ON orders.status_id = statuses.id INNER JOIN menus ON orders.menu_id = menus.id INNER JOIN categories ON menus.category_id = categories.id) AS orders WHERE category = '{$this->category}' AND status_id = 3 GROUP BY order_code ORDER BY order_time ASC"),
            "countmakanan" => DB::select("SELECT count(order_code) AS makanan FROM (SELECT orders.order_code, orders.table_number, orders.customer_name, orders.order_time, orders.status_id, statuses.status, menus.menu, categories.category FROM orders INNER JOIN statuses ON orders.status_id = statuses.id INNER JOIN menus ON orders.menu_id = menus.id INNER JOIN categories ON menus.category_id = categories.id WHERE categories.category = 'makanan' GROUP BY orders.order_code) AS orders WHERE status_id = 3")[0]->makanan,
            "countminuman" => DB::select("SELECT count(order_code) AS minuman FROM (SELECT orders.order_code, orders.table_number, orders.customer_name, orders.order_time, orders.status_id, statuses.status, menus.menu, categories.category FROM orders INNER JOIN statuses ON orders.status_id = statuses.id INNER JOIN menus ON orders.menu_id = menus.id INNER JOIN categories ON menus.category_id = categories.id WHERE categories.category = 'minuman' GROUP BY orders.order_code) AS orders WHERE status_id = 3;")[0]->minuman
        ]);
    }
}