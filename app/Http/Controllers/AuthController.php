<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // create index controller
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {


        $credentials = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if ($credentials->fails()) {
            return back()->with('login', 'errors')->onlyInput('username');
        }
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return Auth::user()->role == 3 ? redirect()->intended('orders') : redirect()->intended('panel');
        }

        return back()->with('login', 'errors')->onlyInput('username');
    }

    // logout the user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'name' => ['required'],
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'numeric', 'min_digits:11'],
            'password' => ['required', 'confirmed'],
        ]);



        if ($credentials->fails()) {
            return back()->with('register', 'errors')->onlyInput('username', 'name', 'email', 'phone');
        }
        $data = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password'),
        ];

        $user = User::create($data);


        return redirect('/login')->with('daftar', 'success');
    }
}
