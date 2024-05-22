<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // index
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('dashboard.index', $data);
    }
}
