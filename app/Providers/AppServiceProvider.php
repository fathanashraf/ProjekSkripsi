<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Profil;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ===== DYNAMIC APP_URL =====
        // Mendukung multi-domain/subdomain: aplikasi bisa diakses dari
        // himanikka.com, himanikka.my.id, himanikka.onrender.com, dll.
        if ($this->app->runningInConsole()) {
            // Saat artisan CLI, tidak ada request HTTP
            // Biarkan APP_URL dari .env digunakan
            return;
        }

        $request = $this->app->request;

        if ($request && $request->server->has('HTTP_HOST')) {
            $scheme = $request->server->get('HTTPS')
                && strtolower($request->server->get('HTTPS')) !== 'off'
                ? 'https'
                : 'http';

            // Cek header proxy (Render, Cloudflare, dll)
            if ($request->server->get('HTTP_X_FORWARDED_PROTO') === 'https') {
                $scheme = 'https';
            }
            // Cloudflare juga kirim X-Forwarded-Proto, jadi CF_VISITOR tidak perlu dicek

            $host = $request->server->get('HTTP_HOST');
            $currentUrl = "{$scheme}://{$host}";

            // Override APP_URL dengan domain saat ini
            config(['app.url' => $currentUrl]);
            URL::forceRootUrl($currentUrl);
            if ($scheme === 'https') {
                URL::forceScheme('https');
            }

            // Trusted proxies untuk Render, Cloudflare, ngrok, dll
            if ($scheme === 'https') {
                $this->app['request']->setTrustedProxies(
                    ['*'],
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO |
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB
                );
            }

            // Session domain: null = per-domain. Set ke ".domain.com" untuk share session antar subdomain.
        }

        // ===== SHARE PROFIL DATA KE SEMUA VIEW =====
        View::composer('*', function ($view) {
            // Query langsung tanpa cache object untuk hindari
            // error 'incomplete object' di PHP 8.4
            $profil = Profil::first();
            $view->with('profil', $profil);
        });
    }
}
