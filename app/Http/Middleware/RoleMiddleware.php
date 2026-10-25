<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle request
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }

        $user = auth()->user();

        // ambil role dari tabel roles via role_id
        $roleName = $user->role_id
            ? \App\Models\Role::find($user->role_id)?->name
            : null;

        if (!$roleName) {
            abort(403, 'Role tidak ditemukan');
        }

        // mapping role khusus
        $mapping = [
            'kahim' => 'admin',
            'dosen' => 'pembina',
            'mahasiswa' => 'mahasiswa',
        ];

        $normalizedRole = strtolower($roleName);
        $effectiveRole = $mapping[$normalizedRole] ?? $normalizedRole;

        // cek apakah role hasil mapping ada di daftar role yang diizinkan
        $allowedRoles = array_map('strtolower', $roles);

        if (!in_array($effectiveRole, $allowedRoles)) {
            abort(
                403,
                'Maaf, Anda terdaftar sebagai: ' . $roleName .
                '. Silakan akses halaman dengan role: ' . implode(', ', $roles)
            );
        }

        return $next($request);
    }
}