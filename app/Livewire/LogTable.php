<?php

namespace App\Livewire;

use App\Models\Log;
use Livewire\Component;
use Livewire\WithPagination;

class LogTable extends Component
{
    use WithPagination;

    public $search;
    public $perPage=5;

    public function render()
    {   
        return view('livewire.log-table',[
            "logs" => Log::where('action', 'like', "%{$this->search}%")->orWhere('time', 'like', "%{$this->search}%")->orWhereRelation('user','username','like',"%{$this->search}%")->orderBy('time','desc')->paginate($this->perPage)
        ]);
    }
}
