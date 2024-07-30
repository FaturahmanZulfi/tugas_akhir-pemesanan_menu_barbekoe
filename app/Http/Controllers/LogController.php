<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function login(){
        return view('login');
    }

    public function logout(){
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'logout'
        ]);
        Auth::logout();
        return redirect('login');
    }

    public function redirect(){
        if (Auth::user()->level_id == 1) {
            return redirect()->route('user');
        }elseif (Auth::user()->level_id == 2) {
            return redirect()->route('laporan');
        }elseif (Auth::user()->level_id == 3 || Auth::user()->level_id == 4 || Auth::user()->level_id == 5 || Auth::user()->level_id == 6) {
            return redirect()->route('pesanan');
        }
    }
}
