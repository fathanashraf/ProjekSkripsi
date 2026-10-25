<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        /*
         * SDK Midtrans bisa saja belum terpasang (composer require midtrans/midtrans).
         * Tanpa guard ini, akses ke Config::$serverKey melempar \Error "Class not found"
         * yang TIDAK tertangkap blok catch (\Exception) di pemanggil,
         * sehingga halaman pembayaran jadi 500.
         * RuntimeException adalah \Exception, jadi tetap tertangkap pemanggil
         * dan halaman tetap terbuka tanpa fitur Snap.
         */
        if (!class_exists(Config::class)) {
            throw new \RuntimeException(
                'SDK Midtrans belum terpasang. Jalankan: composer require midtrans/midtrans'
            );
        }

        // Initialize Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Snap transaction token.
     *
     * @param array $params Transaction details, customer details, item details
     * @return string Snap token
     */
    public function createSnapToken(array $params): string
    {
        return Snap::getSnapToken($params);
    }

    /**
     * Handle incoming notification from Midtrans.
     *
     * @return Notification
     */
    public function handleNotification(): Notification
    {
        return new Notification();
    }

    /**
     * Get transaction status by order_id.
     *
     * @param string $orderId
     * @return object
     */
    public function getTransactionStatus(string $orderId): object
    {
        return Transaction::status($orderId);
    }

    /**
     * Build Snap transaction parameters for pendaftaran payment.
     *
     * @param object $pendaftaran The Pendaftaran model with relations
     * @return array
     */
    public function buildSnapParams($pendaftaran): array
    {
        $user = $pendaftaran->users;
        $acara = $pendaftaran->acaras;
        $biaya = $acara?->biaya;
        $nominal = $biaya?->nominal ?? 0;
        $orderId = 'PEM-' . $pendaftaran->id . '-' . time();

        return [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $nominal,
            ],
            'item_details' => [
                [
                    'id' => $acara?->id ?? 'acara-0',
                    'price' => (int) $nominal,
                    'quantity' => 1,
                    'name' => substr($acara?->name_acara ?? 'Pendaftaran', 0, 50),
                ],
            ],
            'customer_details' => [
                'first_name' => $user?->name ?? $pendaftaran->nama_pendaftar ?? 'Guest',
                'email' => $user?->email ?? 'guest@example.com',
                'phone' => $pendaftaran->NO_HP ?? '-',
            ],
            'callbacks' => [
                'finish' => route('pembayaran.index'),
            ],
            'enabled_payments' => [
                'bank_transfer',
                'credit_card',
                'gopay',
                'shopeepay',
                'other_ewallet',
                'qris',
                'cstore',
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 24,
            ],
        ];
    }
}
