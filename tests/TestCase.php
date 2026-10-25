<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Lapisan pengaman: RefreshDatabase menjalankan migrate:fresh yang
        // MENGHAPUS semua tabel. Pastikan tidak pernah menunjuk ke database asli.
        $default = config('database.default');
        $database = config("database.connections.{$default}.database");

        $isEphemeral = in_array((string) $database, [':memory:', 'testing', 'test'], true)
            || str_ends_with((string) $database, '.sqlite')
            || str_contains((string) $database, '_test');

        if (! $isEphemeral) {
            $this->fail(
                "Tes dibatalkan: koneksi database aktif adalah '{$default}' -> '{$database}'.\n".
                'Menjalankan migrate:fresh akan menghapus data asli. '.
                'Setel DB_CONNECTION=sqlite dan DB_DATABASE=:memory: untuk tes.'
            );
        }
    }
}