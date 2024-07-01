<?php

namespace App\Livewire;

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
            $this->dispatch(
                'sweetalert',
                icon: 'success',
                title: 'Bener',
                position: 'top'
            );
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
