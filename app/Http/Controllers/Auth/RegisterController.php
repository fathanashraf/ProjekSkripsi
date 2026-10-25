<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
       

        $roles = Role::whereNotIn('name', ['admin'])->get();
        return view('auth.register', compact('roles'));
    }public function register(Request $request)
    {
    // Tampilkan pesan jelas saat file melebihi batas upload PHP
    if (empty($_POST) && !empty($_FILES)) {
        return back()
            ->withInput()
            ->with('error', 'Ukuran file terlalu besar. Maksimal '.ini_get('upload_max_filesize').'.');
    }

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],

        'NIM' => ['nullable', 'string', 'max:50', 'unique:users,NIM'],

        'No_hp' => ['nullable', 'string', 'max:20'],

        'alamat' => ['nullable', 'string', 'max:255'],

        'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],

        'role_id' => ['required', 'exists:roles,id'],

        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],

        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    // default avatar
    $avatarPath = null;

    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
    }

    $user = User::create([
        'name' => $validated['name'],
        'NIM' => $validated['NIM'] ?? null,
        'No_hp' => $validated['No_hp'] ?? null,
        'alamat' => $validated['alamat'] ?? null,
        'avatar' => $avatarPath,
        'role_id' => $validated['role_id'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    return redirect()
        ->route('auth.login')
        ->with('success', 'Registrasi berhasil, silakan login');
}


}
