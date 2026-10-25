<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class
        ]);

        // API uses Bearer token auth (Sanctum), not session-based auth.
        // statefulApi() is NOT needed and causes 302 redirects on API routes.

        // Redirect untuk user yang BELUM login ke halaman login
        $middleware->redirectGuestsTo(function () {
            return route('auth.login');
        });

        // Redirect untuk user yang SUDAH login (akses halaman guest seperti /login, /register)
        $middleware->redirectUsersTo(function () {
            $user = auth()->user();
            if (!$user) return route('welcome');

            $role = $user->role?->name;

            return match($role) {
                'admin', 'kahim' => route('admin.dashboard'),
                'mahasiswa' => route('Mahasiswa.beranda.index'),
                'pembina', 'dosen' => route('pembina.beranda.index'),
                default => route('welcome'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
