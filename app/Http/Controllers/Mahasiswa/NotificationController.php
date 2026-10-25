<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Daftar notifikasi untuk mahasiswa (status pendaftaran & pembayaran).
     * Dipanggil secara polling dari halaman mahasiswa agar status approve
     * admin terlihat real-time tanpa perlu refresh.
     */
    public function index(Request $request)
    {
        try {
            $readIds = session()->get('mahasiswa_notifications_read', []);
            $now = now();

            $pendaftarans = Pendaftaran::with(['acaras', 'pembayaran'])
                ->where('user_id', $request->user()->id)
                ->latest()
                ->take(20)
                ->get();

            // Konstanta status di-hoist ke variabel lokal. Pengambilan konstanta kelas
            // langsung di dalam ekspresi match() melempar "Undefined constant" pada
            // SAPI cli-server (server bawaan artisan serve).
            $stDib = Pendaftaran::STATUS_DIBAYAR;
            $stTer = Pendaftaran::STATUS_DITERIMA;
            $stTol = Pendaftaran::STATUS_DITOLAK;

            $notifications = $pendaftarans->map(function ($item) use ($readIds, $now, $stDib, $stTer, $stTol) {
                $id = 'pendaftaran-' . $item->id;
                $status = $item->status;
                $pembayaran = $item->pembayaran;

                [$type, $title, $message] = match ($status) {
                    $stDib => [
                        'pembayaran_lunas',
                        'Pembayaran Lunas',
                        'Pembayaran Anda untuk acara ' . ($item->acaras?->name_acara ?? '-')
                            . ' telah lunas. Terima kasih!',
                    ],
                    $stTer => [
                        'pendaftaran_diterima',
                        'Pendaftaran Disetujui',
                        'Pendaftaran Anda untuk acara ' . ($item->acaras?->name_acara ?? '-')
                            . ' telah disetujui admin. Silakan lakukan pembayaran.',
                    ],
                    $stTol => [
                        'pendaftaran_ditolak',
                        'Pendaftaran Ditolak',
                        'Pendaftaran Anda untuk acara ' . ($item->acaras?->name_acara ?? '-')
                            . ' ditolak admin. Silakan hubungi panitia.',
                    ],
                    default => [
                        'pendaftaran_diajukan',
                        'Pendaftaran Menunggu Verifikasi',
                        'Pendaftaran Anda untuk acara ' . ($item->acaras?->name_acara ?? '-')
                            . ' sedang diverifikasi admin.',
                    ],
                };

                if ($pembayaran && in_array($pembayaran->status, ['dibayar', 'lunas'], true)) {
                    $type = 'pembayaran_lunas';
                    $title = 'Pembayaran Lunas';
                    $message = 'Pembayaran untuk acara ' . ($item->acaras?->name_acara ?? '-')
                        . ' telah dikonfirmasi. Terima kasih!';
                }

                return [
                    'id' => $id,
                    'type' => 'pendaftaran',
                    'data' => [
                        'type' => $type,
                        'title' => $title,
                        'message' => $message,
                    ],
                    'status_pendaftaran' => $status,
                    'status_pembayaran' => $pembayaran?->status,
                    'read_at' => in_array($id, $readIds) ? $now->toISOString() : null,
                    'created_at' => ($item->updated_at ?? $item->created_at ?? $now)->toISOString(),
                    'url' => route('Mahasiswa.pembayaran.index'),
                ];
            })->values();

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => $notifications->whereNull('read_at')->count(),
                'total' => $notifications->count(),
            ]);
        } catch (\Exception $e) {
            Log::error('Notifikasi mahasiswa error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'notifications' => [],
                'unread_count' => 0,
                'total' => 0,
            ], 200);
        }
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(Request $request, $id)
    {
        $readIds = session()->get('mahasiswa_notifications_read', []);

        if (!in_array($id, $readIds)) {
            $readIds[] = $id;
            session()->put('mahasiswa_notifications_read', $readIds);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllRead(Request $request)
    {
        $ids = Pendaftaran::where('user_id', $request->user()->id)
            ->pluck('id')
            ->map(fn($id) => 'pendaftaran-' . $id)
            ->all();

        $merged = array_values(array_unique(array_merge(
            session()->get('mahasiswa_notifications_read', []),
            $ids
        )));

        session()->put('mahasiswa_notifications_read', $merged);

        return response()->json([
            'success' => true,
            'marked_count' => count($ids),
        ]);
    }
}