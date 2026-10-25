<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Acara;
use App\Models\Pendaftaran;
use App\Models\Laporan;
use App\Models\Aspirasi;
use App\Models\Struktur;
use App\Models\Berita;
use App\Models\Keuangan;
use App\Models\Dokumentasi;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Total counts from all models
        $total_pengurus = Struktur::count();
        $total_acara = Acara::count();
        $total_laporan = Laporan::count();
        $total_user = User::count();
        $total_berita = Berita::count();
        $total_pendaftaran = Pendaftaran::count();
        $total_aspirasi = Aspirasi::count();
        $total_dokumentasi = Dokumentasi::count();

        // Pending/action-required counts
        $pending_laporan = Laporan::where('status', 'diajukan')->count();
        $pending_aspirasi = Aspirasi::where('status', 'pending')->count();
        $pending_acara = Acara::where('status', 'pending')->count();
        $pending_pendaftaran = Pendaftaran::where('status', 'diajukan')->count();
        $total_notifications = $pending_laporan + $pending_aspirasi + $pending_acara + $pending_pendaftaran;

        // Recent items
        $recent_users = User::latest()->take(5)->get();
        $recent_acaras = Acara::with('user')->latest()->take(5)->get();
        $recent_pendaftarans = Pendaftaran::with('acaras', 'users')->latest()->take(5)->get();

        // Recent notifications (pending items from all models)
        $recent_notifications_temp = collect()
            ->merge(Laporan::where('status', 'diajukan')->latest()->take(5)->get()->map(fn($i) => [
                'type' => 'laporan',
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'color' => 'amber',
                'title' => 'Laporan Baru',
                'desc' => $i->jenis ?? 'Pengajuan baru',
                'created_at' => $i->created_at,
                'status' => $i->status,
            ]))
            ->merge(Aspirasi::where('status', 'pending')->latest()->take(5)->get()->map(fn($i) => [
                'type' => 'aspirasi',
                'icon' => 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z',
                'color' => 'rose',
                'title' => 'Aspirasi Masuk',
                'desc' => Str::limit($i->Masukkan ?? 'Aspirasi baru'),
                'created_at' => $i->created_at,
                'status' => $i->status,
            ]))
            ->merge(Pendaftaran::where('status', 'diajukan')->latest()->take(5)->get()->map(fn($i) => [
                'type' => 'pendaftaran',
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'emerald',
                'title' => 'Pendaftaran Baru',
                'desc' => ($i->nama_pendaftar ?? $i->users?->name ?? 'Seseorang') . ' mendaftar',
                'created_at' => $i->created_at,
                'status' => $i->status,
            ]))
            ->merge(Acara::where('status', 'pending')->latest()->take(5)->get()->map(fn($i) => [
                'type' => 'acara',
                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'color' => 'blue',
                'title' => 'Acara Baru',
                'desc' => $i->name_acara ?? 'Acara baru diajukan',
                'created_at' => $i->created_at,
                'status' => $i->status,
            ]));

        $recent_notifications = $recent_notifications_temp
            ->sortByDesc(fn($n) => $n['created_at'])
            ->take(8)
            ->map(fn($n) => [
                ...$n,
                'time' => $n['created_at']?->diffForHumans(),
            ])
            ->values();

        // Activity chart data (6 months)
        $activity_chart = collect(range(5, 0))->map(function ($i) {
            $date = Carbon::now()->subMonths($i);
            return [
                'label' => $date->format('M Y'),
                'aktivitas' => Acara::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)->count(),
                'anggota_aktif' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)->count(),
                'pendaftaran' => Pendaftaran::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)->count(),
                'aspirasi' => Aspirasi::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)->count(),
            ];
        });

        $chartData = [
            'labels' => $activity_chart->pluck('label'),
            'acara' => $activity_chart->pluck('aktivitas'),
            'pendaftaran' => $activity_chart->pluck('pendaftaran'),
            'aspirasi' => $activity_chart->pluck('aspirasi'),
        ];

        // Users by role distribution
        $roleDistribution = [
            'label' => ['Admin', 'Mahasiswa', 'Pembina'],
            'data' => [
                User::whereHas('role', fn($q) => $q->where('name', 'admin'))->count(),
                User::whereHas('role', fn($q) => $q->where('name', 'mahasiswa'))->count(),
                User::whereHas('role', fn($q) => $q->where('name', 'pembina'))->count(),
            ],
            'colors' => ['#6366f1', '#10b981', '#f59e0b'],
        ];

        // Struktur count by devisi
        $strukturByDevisi = Struktur::selectRaw('devisi_id, count(*) as total')
            ->with('devisi')
            ->groupBy('devisi_id')
            ->get()
            ->map(fn($s) => [
                'name' => $s->devisi?->name_devisi ?? 'Umum',
                'total' => $s->total,
            ]);



        return view('admin.dashboard', compact(
            'total_pengurus', 'total_acara', 'total_laporan', 'total_user',
            'total_berita', 'total_pendaftaran', 'total_aspirasi', 'total_dokumentasi',
            'pending_laporan', 'pending_aspirasi', 'pending_acara', 'pending_pendaftaran',
            'total_notifications',
            'recent_users', 'recent_acaras', 'recent_pendaftarans',
            'recent_notifications', 'activity_chart', 'chartData',
            'roleDistribution', 'strukturByDevisi',

        ));
    }
}
