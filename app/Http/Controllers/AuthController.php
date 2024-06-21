<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Events\AlertEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
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
            return Auth::user()->role == 3 ? redirect()->intended('orders')->with('success', 'Selamat Datang <b>' . Auth::user()->name . '</b>!') : redirect()->intended('panel')->with('success', 'Selamat Datang <b>' . Auth::user()->name . '</b>!');
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
            'email' => ['required', 'email', 'unique:users'],
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

        event(new AlertEvent(
            role: [1],
            user_id: 0,
            time: Carbon::now()->diffForHumans(),
            alert: '<b>' . $request->name . '</b> berhasil registrasi!',
            color: 'success',
            icon: 'fa-solid fa-user-plus',
            link: '/users/' . $user->id
        ));
        return redirect('/login')->with('daftar', 'success');
    }

    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            // Handle jika autentikasi gagal atau dibatalkan
            return redirect()->route('login')->with('login', 'errors');
        }
    }
    public function GoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $userFromDatabase = User::where('google_id', $user->id)->first();
            // dd($userFromDatabase);
            if (!$userFromDatabase) {
                $data = [
                    'google_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];

                $user = User::create($data);
                // Login user yang baru dibuat
                auth()->login($user);
                session()->regenerate();
                event(new AlertEvent(
                    role: [1],
                    user_id: 0,
                    time: Carbon::now()->diffForHumans(),
                    alert: '<b>' . $user->name . '</b> berhasil registrasi!',
                    color: 'success',
                    icon: 'fa-solid fa-user-plus',
                    link: '/users/' . $user->id
                ));
                return redirect()->intended('orders')->with('success', 'Selamat Datang <b>' . Auth::user()->name . '</b>!');
            }
            auth()->login($userFromDatabase);
            session()->regenerate();
            return redirect()->intended('orders')->with('success', 'Selamat Datang <b>' . Auth::user()->name . '</b>!');
        } catch (Exception $e) {
            // Handle jika autentikasi gagal atau dibatalkan
            return redirect()->route('login')->with('login', 'errors');
        }
    }
}
