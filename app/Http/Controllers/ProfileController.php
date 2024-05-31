<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'profil',
            'user' => $user, // Pastikan mengirim satu objek user
        ];

        // Kembalikan view dengan data
        return view('profile.index', $data);
    }
}
