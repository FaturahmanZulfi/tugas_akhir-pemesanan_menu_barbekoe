<?php

namespace App\Livewire;

use Livewire\Component;

class CustomerScan extends Component
{
    public function mount(){
        if(isset($_COOKIE['has_user_scan'])) {
            return redirect()->route('customer_orders');
        }
    }

    public function scanned(){
        $expired_time = time() + (24 * 60 * 60);
        setcookie("has_user_scan", true, $expired_time, "/");
        return redirect()->route('customer_orders');
    }

    public function render()
    {
        return view('livewire.customer-scan');
    }
}
