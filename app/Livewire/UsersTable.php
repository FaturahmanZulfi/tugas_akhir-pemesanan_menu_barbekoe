<?php

namespace App\Livewire;

use Livewire\Rule;
use App\Models\User;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;
// use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

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

    public $usedusers;

    public function rset(){
        $this->reset(['username', 'password', 'level_id']);
        $this->resetValidation();
    }

    public function createNewUser(){
        $validated = $this->validate([
            'username' => 'required|unique:users|max:8',
            'password' => 'required|max:8',
            'level_id' => 'required'
        ]);

        $validated['password'] = bcrypt($this->password);

        User::create($validated);

        $this->rset();

        $this->dispatch(
            'sweetalert',
            icon: 'success',
            title: 'Data User Berhasil Ditambahkan',
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
            title: 'Data User Berhasil Dihapus',
            position: 'top'
        );

        $this->dispatch(
            'closeoffcanvas',
            offcanvas: 'deleteUser'
        );
    }

    public function updateUser(){
        if($this->username == $this->old_username){
            if ($this->password == "") {
                $validated = $this->validate([
                    'username' => '',
                    'password' => '',
                    'level_id' => 'required'
                ]);

                $validated['password'] = User::find($this->user_id)->password;
            }else {
                $validated = $this->validate([
                    'username' => '',
                    'password' => 'required|max:8',
                    'level_id' => 'required'
                ]);

                $validated['password'] = bcrypt($validated['password']);
            }
        }else {
            if ($this->password == "") {
                $validated = $this->validate([
                    'username' => 'required|max:8',
                    'password' => '',
                    'level_id' => 'required'
                ]);

                $validated['password'] = User::find($this->user_id)->password;
            }else {
                $validated = $this->validate([
                    'username' => 'required|max:8',
                    'password' => 'required|max:8',
                    'level_id' => 'required'
                ]);

                $validated['password'] = bcrypt($validated['password']);
            }
        }

        User::find($this->user_id)->update($validated);

        $this->reset('password');

        $this->dispatch(
            'sweetalert',
            icon: 'warning',
            title: 'Data User Berhasil Diubah',
            position: 'top'
        );
    }
    
    public function render()
    {   
        $useds = DB::select('SELECT DISTINCT(user_id) FROM logs');

        foreach ($useds as $used) {
            $this->usedusers[] = $used->user_id;
        }

        return view('livewire.users-table', [
            'users' => User::with('level')->where('username', 'like', "%{$this->search}%")->orWhereRelation('level','level','like',"%{$this->search}%")->paginate($this->perPage),
            'levels' => Level::all()
        ]);
    }
}
