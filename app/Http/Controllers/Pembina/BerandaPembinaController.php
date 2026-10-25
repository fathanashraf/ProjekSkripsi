<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Acara;
use Carbon\Carbon;
use App\Models\Struktur;
use App\Models\Pendaftaran;
use App\Models\Dokumentasi;
use App\Models\Keuangan;
use App\Models\Laporan;

class BerandaPembinaController extends Controller
{
    public function index()
    {
        $acaras = Acara::count();
        $pendaftaran = Pendaftaran::count();
        $pengurus = Struktur::count();
        $dokumentasi = Dokumentasi::count();
    
        // Generate real chart data from database for last 6 months
        $months = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        });

        $chartLabels = $months->map(fn ($date) => $date->format('M'))->toArray();

        $chartData = [
            'acara' => $months->map(function ($date) {
                return Acara::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            })->toArray(),
            'pengurus' => $months->map(function ($date) {
                return Struktur::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            })->toArray(),
            'keuangan' => $months->map(function ($date) {
                return Keuangan::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            })->toArray(),
            'pendaftaran' => $months->map(function ($date) {
                return Pendaftaran::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            })->toArray(),
        ];
    
        return view('pembina.beranda.index', compact(
            'acaras',
            'pendaftaran',
            'pengurus',
            'dokumentasi',
            'chartLabels',
            'chartData'
        ));
    }
}