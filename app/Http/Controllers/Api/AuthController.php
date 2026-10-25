<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/login
     *
     * Login dan dapatkan Sanctum token.
     *
     * Body: { "email": "...", "password": "..." }
     * Response: { "token": "...", "user": {...} }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Revoke existing tokens (single session per user)
        $user->tokens()->delete();

        // Create new Sanctum token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'NIM' => $user->NIM,
                'role' => $user->role?->name ?? 'user',
                'role_id' => $user->role_id,
                'avatar' => $user->avatar,
            ],
        ]);
    }

    /**
     * POST /api/register
     *
     * Register user baru dan dapatkan Sanctum token.
     *
     * Body: { "name": "...", "email": "...", "password": "...", "password_confirmation": "...", "role_id": 3 }
     * Response: { "token": "...", "user": {...} }
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'NIM' => 'nullable|string|max:50|unique:users,NIM',
            'No_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Cegah register sebagai admin
        $role = Role::find($validated['role_id']);
        if ($role && strtolower($role->name) === 'admin') {
            throw ValidationException::withMessages([
                'role_id' => ['Tidak bisa register sebagai admin.'],
            ]);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'NIM' => $validated['NIM'] ?? null,
            'No_hp' => $validated['No_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'role_id' => $validated['role_id'],
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Register berhasil.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'NIM' => $user->NIM,
                'role' => $user->role?->name ?? 'user',
                'role_id' => $user->role_id,
            ],
        ], 201);
    }

    /**
     * POST /api/logout
     *
     * Logout (revoke current token).
     *
     * Header: Authorization: Bearer {token}
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * DELETE /api/logout-all
     *
     * Logout dari semua device (revoke all tokens).
     *
     * Header: Authorization: Bearer {token}
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Berhasil logout dari semua device.',
        ]);
    }

    /**
     * GET /api/user
     *
     * Dapatkan data user yang sedang login.
     *
     * Header: Authorization: Bearer {token}
     */
    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'NIM' => $user->NIM,
            'No_hp' => $user->No_hp,
            'alamat' => $user->alamat,
            'avatar' => $user->avatar,
            'role' => $user->role?->name ?? 'user',
            'role_id' => $user->role_id,
        ]);
    }
}
