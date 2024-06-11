<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // index
    public function index()
    {
        $data = [
            'title' => 'Home',
            'admin' => User::find(1),
            'products' => Products::take(3)->get()
        ];
        return view('home.index', $data);
    }
}
