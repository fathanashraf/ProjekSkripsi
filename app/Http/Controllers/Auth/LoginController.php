<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profil;

class LoginController extends Controller
{
    public function index()
    {
        $profil = Profil::where('logo', '!=', null)->first() ?? new Profil();
        return view('auth.login', compact('profil'));
    }

    /**
     * PROSES LOGIN
     */
    public function create(Request $request)
    {
        // Jika sudah login (misal dari session lama), redirect ke dashboard
        if (auth()->check()) {
            $role = auth()->user()->role?->name;
            switch ($role) {
                case 'admin':
                case 'kahim':
                    return redirect()->route('admin.dashboard');
                case 'mahasiswa':
                    return redirect()->route('Mahasiswa.beranda.index');
                case 'pembina':
                case 'dosen':
                    return redirect()->route('pembina.beranda.index');
            }
        }
        
        // 1. VALIDASI INPUT
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. CEK LOGIN
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // regenerate session (security)
            $request->session()->regenerate();

            $user = Auth::user();

            // 3. REDIRECT BERDASARKAN ROLE
            $role = $user->role?->name;

            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');

                case 'mahasiswa':
                    return redirect()->route('Mahasiswa.beranda.index')->with('success', 'Selamat datang Mahasiswa!');

                case 'pembina':
                    return redirect()->route('pembina.beranda.index')->with('success', 'Selamat datang Pembina!');
            }

            auth()->logout();
            $request->session()->invalidate();
            return redirect()
                ->route('welcome')
                ->with('error', 'Akun Anda belum memiliki role. Hubungi admin.');
        }

        // 4. LOGIN GAGAL
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('welcome')
            ->with('success', 'Berhasil logout');
    }
}
