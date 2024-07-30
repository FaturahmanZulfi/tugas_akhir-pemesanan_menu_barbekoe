<?php

use App\Livewire\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MidtransController;
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

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LogController::class, 'login'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user', function () {
        return view('users',[
            "active" => "users"
        ]);
    })->name('user')->middleware('userAccess:1');

    Route::get('/log', function () {
        return view('log',[
            "active" => "log"
        ]);
    })->middleware('userAccess:1|2');

    Route::get('/laporan', [ReportController::class, 'report'])->middleware('userAccess:1|2')->name('laporan');

    Route::get('/menu', function () {
        return view('menus',[
            "active" => "menus"
        ]);
    })->middleware('userAccess:4|5');

    Route::get('/pesanan', function () {
        return view('orders',[
            "active" => "orders"
        ]);
    })->name('pesanan')->middleware('userAccess:3|4|5|6');

    Route::get('/logout', [LogController::class, 'logout']);
});

Route::get('/home', [LogController::class, 'redirect']);

// Route::get('/pesanan-sedang-disiapkan', function () {
//     return view('orders-to-prepare');
// });

// Route::get('/pesanan-siap-diantarkan', function () {
//     return view('orders-to-deliver');
// });

//customer

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/scan', [CustomerOrderController::class, 'scan'])->name('scan');

Route::get('/pesanan-saya', [CustomerOrderController::class, 'showOrderList'])->name('customer_orders');

Route::get('/pesan', [CustomerOrderController::class, 'index'])->name('customer_order');

Route::get('/checkout/{order_code}', [CustomerOrderController::class, 'checkout'])->name('checkout');

Route::get('/generate-pdf', [CustomerOrderController::class, 'generatePdf'])->name('generate_pdf');

Route::get('/excel', [ReportController::class, 'excel']);