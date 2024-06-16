<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // index
    public function index()
    {
        $data = [
            'title' => 'Home',
            'admin' => User::find(1),
            'products' => Products::take(3)->get(),
            'reviews' => Orders::where('review', '!=', null)
                ->where('status', 4)
                ->groupBy('user_id') // Group by user_id to get one review per user
                ->inRandomOrder()
                ->take(3)
                ->get()
        ];
        return view('home.index', $data);
    }
}
