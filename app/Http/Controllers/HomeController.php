<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('index', [
            'home' => true,
            'menus' => Menu::all()
        ]);
    }
}
