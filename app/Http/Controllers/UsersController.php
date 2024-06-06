<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengguna',
            'users' => User::where('role', 3)->get()
        ];
        return view('users.index', $data);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $data = [
            'title' => 'Detail Pengguna',
            'user' => $user
        ];
        return view('users.show', $data);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Hapus data berhasil!');
    }
}