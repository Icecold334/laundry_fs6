<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Karyawan',
            'users' => User::all()->where('role', '=', 2)
        ];
        return view('people.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Karyawan'
        ];
        return view('people.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $credentials = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($credentials->fails()) {
            return back()->with('error', 'Tambah Karyawan Gagal')->withErrors($credentials)->onlyInput('username', 'name', 'email');
        }
        //store the resource
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make('password');
        $user->role = 2;
        $user->status = 0;
        $user->save();
        return redirect()->route('people.index')->with('success', 'Tambah data berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $person)
    {
        $data = [
            'title' => 'Karyawan',
            'user' => $person
        ];
        return view('people.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $person)
    {
        $data = [
            'title' => 'Karyawan',
            'user' => $person
        ];
        return view('people.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $person)
    {
        $credentials = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            // 'username' => ['required', 'string', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($credentials->fails()) {
            return back()->with('error', 'Tambah Karyawan Gagal')->withErrors($credentials)->onlyInput('username', 'name', 'email');
        }
        //update the resource
        $person->name = $request->name;
        $person->username = $request->username;
        $person->email = $request->email;
        $person->updated_at = now();
        $person->save();
        return redirect()->route('people.index')->with('success', 'Ubah data berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $person)
    {
        //delete the resource
        $person->delete();
        return redirect()->route('people.index')->with('success', 'Hapus data berhasil!');
    }
}
