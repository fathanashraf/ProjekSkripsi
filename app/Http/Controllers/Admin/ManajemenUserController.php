<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Role;

class ManajemenUserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->orderBy('name')->get();
        $roles = Role::select('id', 'name')->get();
        return view('admin.manajemen.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'NIM' => ['nullable', 'string', 'max:50', 'unique:users,NIM'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'name' => $validated['name'],
            'NIM' => $validated['NIM'] ?? null,
            'No_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'avatar' => $avatarPath,
            'role_id' => $validated['role_id'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'NIM' => ['nullable', 'string', 'max:50', Rule::unique('users', 'NIM')->ignore($user->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $updateData = [
            'name' => $validated['name'],
            'NIM' => $validated['NIM'] ?? null,
            'No_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'role_id' => $validated['role_id'],
            'email' => $validated['email'],
        ];

        if ($avatarPath) {
            $updateData['avatar'] = $avatarPath;
        }

        if (!empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $user->update($updateData);

        return back()->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        Storage::disk('public')->delete($user->avatar);
    }

    $user->delete();

    return back()->with('success', 'User berhasil dihapus.');
}
}