<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerOrderController;
use App\Livewire\Login;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', function () {
    return view('login');
});

Route::get('/user', function () {
    return view('users');
});

Route::get('/menu', function () {
    return view('menus');
});

Route::get('/pesanan', function () {
    return view('orders');
});

Route::get('/pesanan-sedang-disiapkan', function () {
    return view('orders-to-prepare');
});

Route::get('/pesanan-siap-diantarkan', function () {
    return view('orders-to-deliver');
});

//customer
Route::get('/scan', [CustomerOrderController::class, 'scan'])->name('scan');

Route::get('/pesanan-saya', [CustomerOrderController::class, 'showOrderList'])->name('customer_orders');

Route::get('/pesan', [CustomerOrderController::class, 'index'])->name('customer_order');

Route::get('/checkout/{order_code}', [CustomerOrderController::class, 'checkout'])->name('checkout');