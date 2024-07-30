<?php

namespace App\Livewire;

use App\Models\Log;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $username;
    public $password;

    public function login(){
        $validated = $this->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validated)) {
            Log::create([
                'user_id' => Auth::user()->id,
                'action' => 'login'
            ]);

            $this->dispatch(
                'sweetalert',
                icon: 'success',
                title: 'Selamat Datang',
                position: 'top'
            );

            if (Auth::user()->level_id == 1) {
                return redirect()->route('user');
            }elseif (Auth::user()->level_id == 2) {
                return redirect()->route('laporan');
            }elseif (Auth::user()->level_id == 3 || Auth::user()->level_id == 4 || Auth::user()->level_id == 5 || Auth::user()->level_id == 6) {
                return redirect()->route('pesanan');
            }
        }else{
            $this->dispatch(
                'sweetalert',
                icon: 'error',
                title: 'Username Atau Password Salah',
                position: 'top'
            );
        }
    }

    public function render()
    {
        return view('livewire.login');
    }
}
