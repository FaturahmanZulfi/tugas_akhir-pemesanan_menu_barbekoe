<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function orderwithppn(){
        return $this->hasMany(OrderWithPpn::class);
    }
}
