<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerOrderController;

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

Route::get('/user', function () {
    return view('users');
});

Route::get('/menu', function () {
    return view('menus');
});

Route::get('/pesanan', function () {
    return view('orders');
});



//customer
Route::get('/pesan', [CustomerOrderController::class, 'index']);

Route::get('/checkout/{order_code}', [CustomerOrderController::class, 'checkout'])->name('checkout');