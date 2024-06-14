<?php

namespace App\Livewire;

use Livewire\Rule;
use App\Models\User;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;
// use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Validate;

class UsersTable extends Component
{
    use WithPagination;
    
    public $perPage = 5;
    public $search = '';

    public $username;
    public $old_username;
    public $password;    
    public $level_id = 1;

    public $user_id = 0;

    public function rset(){
        $this->reset(['username', 'password', 'level_id']);
        $this->resetValidation();
    }

    public function createNewUser(){
        $validated = $this->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'level_id' => 'required'
        ]);

        User::create($validated);

        $this->rset();

        $this->dispatch(
            'sweetalert',
            icon: 'success',
            title: 'Data Berhasil Ditambahkan',
            position: 'top'
        );
    }

    public function getUser($userId){
        $this->resetValidation();
        $user = User::find($userId);
        $this->user_id = $userId;
        $this->username = $user->username;
        $this->old_username = $user->username;
        $this->password = "";
        $this->level_id = $user->level_id;
    }

    public function deleteUser(){
        User::find($this->user_id)->delete();

        $this->rset();
        $this->reset('user_id');

        $this->dispatch(
            'sweetalert',
            icon: 'error',
            title: 'Data Berhasil Dihapus',
            position: 'top'
        );
    }

    public function updateUser(){
        if ($this->password == "") {
            $this->password = User::find($this->user_id)->password;
        }

        if($this->username == $this->old_username){
            $validated = $this->validate([
                'username' => '',
                'password' => 'required',
                'level_id' => 'required'
            ]);
        }else {
            $validated = $this->validate([
                'username' => 'required',
                'password' => 'required',
                'level_id' => 'required'
            ]);
        }

        User::find($this->user_id)->update($validated);

        $this->reset('password');

        $this->dispatch(
            'sweetalert',
            icon: 'warning',
            title: 'Data Berhasil Diubah',
            position: 'top'
        );
    }
    
    public function render()
    {   
        return view('livewire.users-table', [
            'users' => User::with('level')->where('username', 'like', "%{$this->search}%")->orWhereRelation('level','level','like',"%{$this->search}%")->paginate($this->perPage),
            'levels' => Level::all()
        ]);
    }
}
