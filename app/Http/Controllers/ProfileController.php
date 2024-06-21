<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Profil',
            'user' => $user, // Pastikan mengirim satu objek user
        ];

        // Kembalikan view dengan data
        return view('profile.index', $data);
    }
    public function edit()
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Profil',
            'user' => $user, // Pastikan mengirim satu objek user
        ];

        // Kembalikan view dengan data
        return view('profile.edit', $data);
    }


    public function update(Request $request, User $user)
    {
        if ($user->google_id == null) {
            $ruleUsername = $request->username != $user->username
                ? ['required', 'string', 'max:255', 'unique:users']
                : ['required', 'string', 'max:255'];
        } else {
            $ruleUsername = '';
        }
        $ruleemail = $request->email != $user->email
            ? ['required', 'string', 'email', 'max:255', 'unique:users']
            : ['required', 'string', 'email', 'max:255'];
        $credentials = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => $ruleUsername,
            'phone' => 'required|numeric|min_digits:11',
            'email' => $ruleemail,
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => 'Nama tidak boleh kosong!',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter!',
            'username.required' => 'Username tidak boleh kosong!',
            'username.string' => 'Username tidak boleh kosong!',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter!',
            'username.unique' => 'Username sudah digunakan!',
            'phone.required' => 'Nomor telepon tidak boleh kosong!',
            'phone.numeric' => 'Nomor telepon harus berupa angka!',
            'phone.min_digits' => 'Nomor telepon minimal 11 digit!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.string' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter!',
            'email.unique' => 'Email sudah digunakan',
        ]);
        if ($credentials->fails()) {
            return back()->with('error', 'Ubah profil gagal!')->withErrors($credentials)->onlyInput('username', 'name', 'email', 'phone');
        }


        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            Storage::delete('public/people/' . $user->img);
            $img = $request->file('img')->store('public/people');
            $img = str_replace('public/people/', '', $img);
        } else {
            $img = $user->img;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->img = $img;
        $user->update();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }


    public function password()
    {
        if (Auth::user()->google_id != null) {
            abort(403);
        }
        return view('profile.password', [
            'title' => 'Profil'
        ]);
    }

    public function updatepass(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'current_password' => ['required'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required']
        ], [
            'current_password.required' => 'Password Tidak Boleh Kosong.',
            'password.required' => 'Password Tidak Boleh Kosong.',
            'password.confirmed' => 'Password Tidak Cocok.',
            'password_confirmation.required' => 'Password Tidak Boleh Kosong.',
        ]);
        if ($credentials->fails()) {
            return redirect()->back()->with('error', 'Ubah password gagal!')->withErrors($credentials);
        }

        $user = User::find(Auth::user()->id);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Ubah password gagal!')->withErrors(['current_password' => 'Password Salah.']);
        }

        $user->password = Hash::make($request->password);
        $user->update();

        return redirect()->route('profile.index')->with('success', 'Ubah password berhasil!');
    }
}
