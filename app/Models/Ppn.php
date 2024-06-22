<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppn extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];
}
