<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Keuangan;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * POST /api/payment/snap-token
     *
     * Generate Midtrans Snap token untuk pendaftaran tertentu.
     *
     * Request: { "pendaftaran_id": 1 }
     * Response: { "snap_token": "...", "client_key": "...", "order_id": "..." }
     */
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
        ]);

        $user = $request->user();

        $pendaftaran = Pendaftaran::with(['acaras.biaya', 'users'])
            ->where('id', $request->pendaftaran_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$pendaftaran) {
            return response()->json(['message' => 'Pendaftaran tidak ditemukan atau bukan milik Anda.'], 404);
        }

        if (!$pendaftaran->acaras?->biaya) {
            return response()->json(['message' => 'Acara ini belum memiliki biaya pendaftaran.'], 422);
        }

        if (!$pendaftaran->isDisetujui()) {
            return response()->json([
                'message' => 'Pendaftaran belum disetujui admin. Pembayaran belum dapat dilakukan.',
                'status_pendaftaran' => $pendaftaran->status,
            ], 403);
        }

        if ($pendaftaran->isLunas()) {
            return response()->json([
                'message' => 'Pembayaran untuk pendaftaran ini sudah lunas.',
                'status_pendaftaran' => $pendaftaran->status,
            ], 422);
        }

        try {
            $midtrans = new MidtransService();
            $params = $midtrans->buildSnapParams($pendaftaran);
            $snapToken = $midtrans->createSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'client_key' => config('midtrans.client_key'),
                'order_id' => $params['transaction_details']['order_id'],
                'gross_amount' => $params['transaction_details']['gross_amount'],
            ]);
        } catch (\Exception $e) {
            Log::error('Snap token generation failed', [
                'pendaftaran_id' => $pendaftaran->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Gagal membuat token pembayaran.'], 500);
        }
    }

    /**
     * POST /api/payment/store
     *
     * Simpan pembayaran manual (transfer / cash).
     *
     * Request: { "pendaftaran_id": 1, "jenis": "kredit", "bukti_pembayaran": file }
     * Response: { "message": "...", "pembayaran": {...} }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
            'jenis' => 'required|in:kredit,cash',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = $request->user();

        $pendaftaran = Pendaftaran::with('acaras.biaya')
            ->where('id', $validated['pendaftaran_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$pendaftaran) {
            return response()->json(['message' => 'Pendaftaran tidak ditemukan atau bukan milik Anda.'], 404);
        }

        if (!$pendaftaran->isDisetujui()) {
            return response()->json([
                'message' => 'Pendaftaran belum disetujui admin. Pembayaran belum dapat dilakukan.',
                'status_pendaftaran' => $pendaftaran->status,
            ], 403);
        }

        if ($pendaftaran->isLunas()) {
            return response()->json([
                'message' => 'Pembayaran untuk pendaftaran ini sudah lunas.',
                'status_pendaftaran' => $pendaftaran->status,
            ], 422);
        }

        // Check if already paid
        $existingPayment = Pembayaran::where('pendaftaran_id', $pendaftaran->id)
            ->whereIn('status', ['dibayar', 'lunas'])
            ->first();

        if ($existingPayment) {
            return response()->json(['message' => 'Pembayaran untuk pendaftaran ini sudah dilunasi.'], 422);
        }

        $jumlahBayar = $pendaftaran->acaras?->biaya?->nominal ?? 0;

        DB::transaction(function () use ($request, $validated, $pendaftaran, $jumlahBayar, $user, &$pembayaran) {
            $path = null;
            $status = 'belum_dibayar';

            if ($validated['jenis'] === 'kredit') {
                if (!$request->hasFile('bukti_pembayaran')) {
                    return response()->json(['message' => 'Bukti pembayaran wajib diupload untuk pembayaran transfer.'], 422);
                }
                $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
                $status = 'dibayar';
            }

            $pembayaran = Pembayaran::create([
                'user_id' => $user->id,
                'acara_id' => $pendaftaran->acaras_id,
                'pendaftaran_id' => $pendaftaran->id,
                'jenis' => $validated['jenis'],
                'bukti_pembayaran' => $path,
                'status' => $status,
            ]);

            if ($status === 'dibayar') {
                Keuangan::create([
                    'user_id' => $user->id,
                    'acara_id' => $pendaftaran->acaras_id,
                    'pendaftaran_id' => $pendaftaran->id,
                    'pembayarans_id' => $pembayaran->id,
                    'pembayaran_id' => $pembayaran->id,
                    'jenis' => 'pemasukan',
                    'kategori' => 'pendaftaran',
                    'nominal' => $jumlahBayar,
                    'bulan' => now()->toDateString(),
                    'total' => $jumlahBayar,
                    'biaya_id' => $pendaftaran->acaras?->biaya_id,
                ]);

                $pendaftaran->update(['status' => Pendaftaran::STATUS_DIBAYAR]);
            }
        });

        return response()->json([
            'message' => 'Pembayaran berhasil dikirim.',
            'pembayaran' => $pembayaran,
        ]);
    }

    /**
     * POST /api/payment/midtrans-notification
     *
     * Webhook handler untuk notifikasi Midtrans.
     * Endpoint ini TIDAK dilindungi CSRF.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function midtransNotification(Request $request)
    {
        try {
            $midtrans = new MidtransService();
            $notification = $midtrans->handleNotification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $fraudStatus = $notification->fraud_status;
            $grossAmount = $notification->gross_amount;

            Log::info('Midtrans notification received', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'payment_type' => $paymentType,
                'gross_amount' => $grossAmount,
            ]);

            // Extract pendaftaran_id from order_id: PEM-{id}-{timestamp}
            $pendaftaranId = null;
            if (preg_match('/^PEM-(\d+)-/', $orderId, $matches)) {
                $pendaftaranId = (int) $matches[1];
            }

            if (!$pendaftaranId) {
                Log::error('Invalid order_id format', ['order_id' => $orderId]);
                return response()->json(['message' => 'Invalid order_id'], 400);
            }

            $pendaftaran = Pendaftaran::with('acaras')->find($pendaftaranId);
            if (!$pendaftaran) {
                Log::error('Pendaftaran not found', ['pendaftaran_id' => $pendaftaranId]);
                return response()->json(['message' => 'Pendaftaran not found'], 404);
            }

            $paymentStatus = $this->mapMidtransStatus($transactionStatus, $fraudStatus);

            DB::transaction(function () use ($pendaftaran, $orderId, $paymentStatus, $transactionStatus, $paymentType, $grossAmount) {
                $pembayaran = Pembayaran::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran->id],
                    [
                        'user_id' => $pendaftaran->user_id,
                        'acara_id' => $pendaftaran->acaras_id,
                        'jenis' => $paymentType ?? 'midtrans',
                        'status' => $paymentStatus,
                        'bukti_pembayaran' => null,
                    ]
                );

                if ($paymentStatus === 'dibayar' || $paymentStatus === 'lunas') {
                    $pendaftaran->update(['status' => Pendaftaran::STATUS_DIBAYAR]);

                    $biayaAcara = $pendaftaran->acaras?->biaya;
                    $nominal = $biayaAcara?->nominal ?? $grossAmount ?? 0;

                    // Avoid duplicate keuangan
                    $existingKeuangan = Keuangan::where('pembayaran_id', $pembayaran->id)->first();
                    if (!$existingKeuangan) {
                        Keuangan::create([
                            'user_id' => $pendaftaran->user_id,
                            'acara_id' => $pendaftaran->acaras_id,
                            'pendaftaran_id' => $pendaftaran->id,
                            'pembayarans_id' => $pembayaran->id,
                            'pembayaran_id' => $pembayaran->id,
                            'jenis' => 'pemasukan',
                            'kategori' => 'pendaftaran',
                            'nominal' => $nominal,
                            'bulan' => now()->toDateString(),
                            'total' => $nominal,
                            'biaya_id' => $pendaftaran->acaras?->biaya_id,
                        ]);
                    }
                }
            });

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }

    /**
     * GET /api/payment/status/{pendaftaran_id}
     *
     * Cek status pembayaran untuk pendaftaran tertentu.
     */
    public function status($pendaftaranId, Request $request)
    {
        $user = $request->user();

        $pendaftaran = Pendaftaran::with(['pembayaran', 'acaras.biaya'])
            ->where('id', $pendaftaranId)
            ->where('user_id', $user->id)
            ->first();

        if (!$pendaftaran) {
            return response()->json(['message' => 'Pendaftaran tidak ditemukan.'], 404);
        }

        return response()->json([
            'pendaftaran_id' => $pendaftaran->id,
            'status_pendaftaran' => $pendaftaran->status,
            'pembayaran' => $pendaftaran->pembayaran ? [
                'id' => $pendaftaran->pembayaran->id,
                'jenis' => $pendaftaran->pembayaran->jenis,
                'status' => $pendaftaran->pembayaran->status,
                'bukti_pembayaran' => $pendaftaran->pembayaran->bukti_pembayaran,
                'created_at' => $pendaftaran->pembayaran->created_at,
            ] : null,
            'biaya' => $pendaftaran->acaras?->biaya ? [
                'nominal' => $pendaftaran->acaras->biaya->nominal,
                'formatted' => 'Rp ' . number_format($pendaftaran->acaras->biaya->nominal, 0, ',', '.'),
            ] : null,
        ]);
    }

    /**
     * Map Midtrans transaction status to local payment status.
     */
    private function mapMidtransStatus(string $transactionStatus, ?string $fraudStatus = null): string
    {
        return match ($transactionStatus) {
            'capture' => $fraudStatus === 'accept' ? 'dibayar' : 'menunggu',
            'settlement' => 'lunas',
            'pending' => 'menunggu',
            'deny' => 'ditolak',
            'expire' => 'kadaluarsa',
            'cancel' => 'dibatalkan',
            default => 'menunggu',
        };
    }
}
