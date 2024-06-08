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
            'title' => 'Profil',
            'user' => $user, // Pastikan mengirim satu objek user
        ];

        // Kembalikan view dengan data
        return view('profile.index', $data);
    }

    
    // Update foto profil
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|string|email|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('profile_image')) {
        // Hapus gambar lama jika ada
        if ($user->profile_image) {
            $oldImage = public_path('images/') . $user->profile_image;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }
        
        // Unggah gambar baru
        $image = $request->file('profile_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $data['profile_image'] = $imageName;
    }

    // Perbarui data pengguna
    $user->update($data);

    return redirect()->back()->with('success', 'Profil berhasil diperbarui');
}


}