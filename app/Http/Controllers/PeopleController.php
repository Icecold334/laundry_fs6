<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
            'phone' => ['required', 'numeric', 'min_digits:11'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
            return back()->with('error', 'Tambah Karyawan Gagal')->withErrors($credentials)->onlyInput('username', 'name', 'email', 'phone');
        }
        //store the resource
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
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
        Gate::allowIf($person->role == 2);
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
        // validation
        $ruleusername = $request->username != $person->username
            ? ['required', 'string', 'max:255', 'unique:users']
            : ['required', 'string', 'max:255'];
        $ruleemail = $request->email != $person->email
            ? ['required', 'string', 'email', 'max:255', 'unique:users']
            : ['required', 'string', 'email', 'max:255'];
        $credentials = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => $ruleusername,
            'phone' => ['required', 'numeric', 'min_digits:11'],
            'email' => $ruleemail,
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
            return back()->with('error', 'Tambah Karyawan Gagal')->withErrors($credentials)->onlyInput('username', 'name', 'email', 'phone');
        }
        //update the resource
        $person->name = $request->name;
        $person->username = $request->username;
        $person->phone = $request->phone;
        $person->email = $request->email;
        $person->update();
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

    /**
     * Force delete the specified resource from storage.
     */
    public function force(User $person)
    {
        // Force delete the resource
        $person->forceDelete();
        return redirect()->route(User::onlyTrashed()->where('role', 2)->count() > 0 ? 'people.trash' : 'people.index')->with('success', 'Karyawan Berhasil Dihapus!');
    }

    /**
     * Display a listing of the trashed resources.
     */
    public function trash()
    {
        if (User::onlyTrashed()->where('role', 2)->count() == 0) {
            return redirect()->route('people.index');
        }

        $data = [
            'title' => 'Karyawan',
            'users' => User::onlyTrashed()->where('role', 2)->get()
        ];

        return view('people.trash', $data);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        // Restore the resource
        User::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route(User::onlyTrashed()->where('role', 2)->count() > 0 ? 'people.trash' : 'people.index')->with('success', 'Karyawan Berhasil Dipulihkan!');
    }
}
