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
        return $this->hasMany(Order::class, 'order_code', 'order_code');
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }
}
