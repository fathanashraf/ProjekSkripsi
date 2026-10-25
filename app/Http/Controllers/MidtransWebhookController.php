<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Keuangan;
use App\Models\Pendaftaran;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    /**
     * Handle Midtrans payment notification (webhook).
     *
     * Midtrans sends POST request to this endpoint when payment status changes.
     * This endpoint must NOT be protected by CSRF.
     */
    public function notification(Request $request)
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

            // Determine payment status based on Midtrans transaction status
            $paymentStatus = $this->mapMidtransStatus($transactionStatus, $fraudStatus);

            DB::transaction(function () use ($pendaftaran, $orderId, $paymentStatus, $transactionStatus, $paymentType, $grossAmount) {
                // Find or create pembayaran record
                $pembayaran = Pembayaran::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran->id],
                    [
                        'user_id' => $pendaftaran->user_id,
                        'acara_id' => $pendaftaran->acaras_id,
                        'jenis' => $paymentType ?? 'midtrans',
                        'status' => $paymentStatus,
                        'bukti_pembayaran' => null, // No manual upload needed
                    ]
                );

                // Update pendaftaran status
                if ($paymentStatus === 'dibayar' || $paymentStatus === 'lunas') {
                    $pendaftaran->update(['status' => 'diajukan']);

                    // Create keuangan record if paid
                    $biayaAcara = $pendaftaran->acaras?->biaya;
                    $nominal = $biayaAcara?->nominal ?? $grossAmount ?? 0;

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
