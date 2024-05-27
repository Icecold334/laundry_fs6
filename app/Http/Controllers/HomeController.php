<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // index
    public function index()
    {
        $data = [
            'title' => 'Home',
        ];
        return view('home.index', $data);
    }
}
