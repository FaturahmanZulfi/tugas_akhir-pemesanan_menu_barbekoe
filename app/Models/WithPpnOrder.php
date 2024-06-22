<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithPpnOrder extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    public function order(){
        return $this->hasMany(Order::class);
    }
}
