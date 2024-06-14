<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function index()
    {
        Gate::allowIf(Auth::user()->role != 3);
        $data = [
            'title' => 'Pengguna',
            'users' => User::where('role', 3)->get()
        ];
        return view('users.index', $data);
    }

    public function show(User $user)
    {
        $user->trashed() ? Gate::authorize('superadmin') : '';
        $data = [
            'title' => 'Detail Pengguna',
            'user' => $user
        ];
        return view('users.show', $data);
    }

    public function destroy(User $user)
    {
        if (Orders::where('user_id', $user->id)->where('status', '<', 4)->count() > 0) {
            return redirect()->route('users.index')->with('error', "Pesanan Milik $user->name Belum Selesai!");
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Hapus data berhasil!');
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();
        if ($users->isEmpty()) {
            abort(403);
        }

        $data = [
            'title' => 'Sampah Pengguna',
            'users' => $users
        ];

        return view('users.trash', $data);
    }

    public function restore(User $user)
    {
        $user->restore();
        return redirect()->route(User::onlyTrashed()->count() > 0 ? 'users.trash' : 'users.index')->with('success', 'Pengguna berhasil dipulihkan!');
    }

    public function force(User $user)
    {
        $user->forceDelete();
        return redirect()->route(User::onlyTrashed()->count() > 0 ? 'users.trash' : 'users.index')->with('success', 'Pengguna berhasil dihapus permanen!');
    }
}
