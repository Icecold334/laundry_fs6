<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'profil',
        ];
        return view('profile.index', $data);
    }
}
