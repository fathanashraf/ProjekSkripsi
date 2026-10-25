<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\Aspirasi;
use App\Models\Laporan;
use App\Models\Pendaftaran;
use App\Models\Struktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    /**
     * Get all notifications for admin (aggregated from multiple models)
     */
    public function index(Request $request)
    {
        try {
            $readIds = session()->get('notifications_read', []);
            $now = now();

            // Helper: format notification
            $format = function ($items, callable $fn) use ($readIds, $now) {
                return collect($items)->map(function ($item) use ($readIds, $fn, $now) {
                    $result = $fn($item);
                    $id = $result['id'];
                    return [
                        'id' => $id,
                        'type' => $result['type'] ?? 'general',
                        'data' => [
                            'type' => $result['data_type'] ?? 'info',
                            'title' => $result['title'] ?? 'Notifikasi',
                            'message' => $result['message'] ?? '',
                        ],
                        'read_at' => in_array($id, $readIds) ? $now->toISOString() : null,
                        'created_at' => $item->created_at? $item->created_at->toISOString() : $now->toISOString(),
                    ];
                });
            };

            // 1. Laporan pending
            $laporans = $format(Laporan::with('acara.user')
                ->where('status', 'diajukan')
                ->latest()->take(10)->get(), fn($item) => [
                'id' => 'laporan-' . $item->id,
                'type' => 'laporan',
                'data_type' => 'laporan_baru',
                'title' => 'Pengajuan Baru',
                'message' => 'Laporan ' . ($item->jenis ?? 'baru') . ' dari ' . ($item->acara?->user?->name ?? 'Pengurus'),
            ]);

            // 2. Aspirasi pending
            $aspirasis = $format(Aspirasi::with('user')
                ->where('status', 'pending')
                ->latest()->take(10)->get(), fn($item) => [
                'id' => 'aspirasi-' . $item->id,
                'type' => 'aspirasi',
                'data_type' => 'aspirasi_created',
                'title' => 'Aspirasi Masuk',
                'message' => 'Aspirasi baru dari ' . ($item->user?->name ?? 'Mahasiswa') . ': ' . Str::limit($item->Masukkan ?? '', 80),
            ]);

            // 3. Pendaftaran diajukan
            $pendaftarans = $format(Pendaftaran::with('acaras', 'users')
                ->where('status', 'diajukan')
                ->latest()->take(10)->get(), fn($item) => [
                'id' => 'pendaftaran-' . $item->id,
                'type' => 'pendaftaran',
                'data_type' => 'pendaftaran_baru',
                'title' => 'Pendaftaran Baru',
                'message' => ($item->nama_pendaftar ?? $item->users?->name ?? 'Seseorang') . ' mendaftar ' . ($item->acaras?->name_acara ?? 'acara'),
            ]);

            // 4. Acara pending
            $acaras = $format(Acara::with('user')
                ->where('status', 'pending')
                ->latest()->take(10)->get(), fn($item) => [
                'id' => 'acara-' . $item->id,
                'type' => 'acara',
                'data_type' => 'acara_created',
                'title' => 'Acara Baru',
                'message' => 'Acara "' . ($item->name_acara ?? 'Baru') . '" oleh ' . ($item->user?->name ?? 'Pengurus'),
            ]);

            // 5. Struktur baru (7 hari terakhir)
            $strukturs = $format(Struktur::with('user', 'jabatan')
                ->where('created_at', '>=', now()->subDays(7))
                ->latest()->take(10)->get(), fn($item) => [
                'id' => 'struktur-' . $item->id,
                'type' => 'struktur',
                'data_type' => 'struktur_created',
                'title' => 'Anggota Baru',
                'message' => ($item->user?->name ?? 'Anggota baru') . ' sebagai ' . ($item->jabatan?->name_jabatan ?? 'Pengurus'),
            ]);

            // Merge, sort, take 20
            $notifications = $laporans->merge($aspirasis)->merge($pendaftarans)->merge($acaras)->merge($strukturs)
                ->sortByDesc('created_at')->take(20)->values();

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => $notifications->whereNull('read_at')->count(),
                'total' => $notifications->count(),
            ]);
        } catch (\Exception $e) {
            Log::error('Notifikasi index error: ' . $e->getMessage(), [
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
     * Mark a single notification as read
     */
    public function markRead(Request $request, $id)
    {
        try {
            $readIds = session()->get('notifications_read', []);
            if (!in_array($id, $readIds)) {
                $readIds[] = $id;
                session()->put('notifications_read', $readIds);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Notifikasi markRead error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead(Request $request)
    {
        try {
            $readIds = session()->get('notifications_read', []);

            $allIds = collect()
                ->merge(Laporan::where('status', 'diajukan')->pluck('id')->map(fn($id) => 'laporan-' . $id))
                ->merge(Aspirasi::where('status', 'pending')->pluck('id')->map(fn($id) => 'aspirasi-' . $id))
                ->merge(Pendaftaran::where('status', 'diajukan')->pluck('id')->map(fn($id) => 'pendaftaran-' . $id))
                ->merge(Acara::where('status', 'pending')->pluck('id')->map(fn($id) => 'acara-' . $id))
                ->merge(Struktur::where('created_at', '>=', now()->subDays(7))->pluck('id')->map(fn($id) => 'struktur-' . $id))
                ->unique()->values()->toArray();

            $mergedIds = array_unique(array_merge($readIds, $allIds));
            session()->put('notifications_read', $mergedIds);

            return response()->json([
                'success' => true,
                'marked_count' => count($allIds),
            ]);
        } catch (\Exception $e) {
            Log::error('Notifikasi markAllRead error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}
