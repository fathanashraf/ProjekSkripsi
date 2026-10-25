<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Keuangan;
use App\Models\Acara;

class KeuanganPembinaController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::with(['pembayaran', 'user', 'acara', 'pendaftaran', 'biaya'])
            ->latest()
            ->get();

        // Statistik lengkap seperti admin
        $totalPembayaran = $keuangans->count();
        $totalPeserta = Pembayaran::count();
        $totalAcara = Acara::count();
        $totalPemasukan = $keuangans->where('jenis', 'pemasukan')->sum('nominal');
        $totalMidtrans = $keuangans->filter(fn($k) => $k->pembayaran && $k->pembayaran->jenis === 'midtrans')->count();
        $totalManual = $keuangans->filter(fn($k) => $k->pembayaran && in_array($k->pembayaran->jenis, ['cash', 'kredit']))->count();
        $totalMetode = Pembayaran::select('jenis')->distinct()->count();

        // Hitung chart data real dari database per bulan (Jan-Des)
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartPemasukan = array_fill(0, 12, 0);
        $chartPengeluaran = array_fill(0, 12, 0);

        foreach ($keuangans as $k) {
            $monthIndex = (int) $k->created_at->format('n') - 1;
            if ($monthIndex < 0 || $monthIndex > 11) continue;

            $nominal = (int) ($k->biaya->nominal ?? $k->nominal ?? 0);

            if ($k->jenis === 'pemasukan') {
                $chartPemasukan[$monthIndex] += $nominal;
            } else {
                $chartPengeluaran[$monthIndex] += $nominal;
            }
        }

        $chartData = [
            'labels' => $monthNames,
            'pemasukan' => $chartPemasukan,
            'pengeluaran' => $chartPengeluaran,
        ];

        return view(
            'pembina.keuangan.index',
            compact(
                'keuangans',
                'chartData',
                'totalPembayaran',
                'totalPeserta',
                'totalAcara',
                'totalMetode',
                'totalMidtrans',
                'totalManual'
            )
        );
    }
}
