<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.fonnte.api_key', env('FONNTE_API_KEY', ''));
        $this->baseUrl = 'https://api.fonnte.com';
    }

    /**
     * Send a WhatsApp message via Fonnte.
     *
     * @param string $target Phone number(s). Can be comma separated for multiple.
     * @param string $message The message text.
     * @param array $options Additional options (countryCode, schedule, etc.)
     * @return array
     */
    public function sendMessage(string $target, string $message, array $options = []): array
    {
        if (empty($this->apiKey)) {
            Log::warning('WhatsApp: API key not configured');
            return ['status' => false, 'message' => 'API key not configured'];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->post("{$this->baseUrl}/send", array_merge([
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Indonesia
            ], $options));

            if ($response->successful()) {
                $body = $response->json();
                Log::info('WhatsApp sent successfully', [
                    'target' => $target,
                    'response' => $body,
                ]);
                return ['status' => true, 'data' => $body];
            }

            Log::warning('WhatsApp send failed', [
                'target' => $target,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return ['status' => false, 'message' => $response->body()];
        } catch (\Exception $e) {
            Log::error('WhatsApp exception', [
                'target' => $target,
                'error' => $e->getMessage(),
            ]);

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send OTP or verification code.
     */
    public function sendOtp(string $target, string $code): array
    {
        $message = "*HIMANIKKA - Kode Verifikasi*\n\n";
        $message .= "Kode OTP Anda: *{$code}*\n\n";
        $message .= "Kode berlaku selama 5 menit.\n";
        $message .= "Jangan bagikan kode ini kepada siapapun.\n\n";
        $message .= "— HIMANIKKA UPTT";

        return $this->sendMessage($target, $message);
    }

    /**
     * Send notification about event approval.
     */
    public function sendEventApproval(string $target, string $eventName, string $status): array
    {
        $statusText = $status === 'approved' ? 'DISETUJUI ✅' : 'DITOLAK ❌';
        $message = "*HIMANIKKA - Status Acara*\n\n";
        $message .= "Acara: *{$eventName}*\n";
        $message .= "Status: *{$statusText}*\n\n";
        $message .= "Login untuk melihat detail.\n";
        $message .= "— HIMANIKKA UPTT";

        return $this->sendMessage($target, $message);
    }

    /**
     * Send notification about payment confirmation.
     */
    public function sendPaymentConfirmation(string $target, string $eventName): array
    {
        $message = "*HIMANIKKA - Pembayaran Dikonfirmasi*\n\n";
        $message .= "Acara: *{$eventName}*\n";
        $message .= "Status: *LUNAS ✅*\n\n";
        $message .= "Terima kasih telah melakukan pembayaran.\n";
        $message .= "— HIMANIKKA UPTT";

        return $this->sendMessage($target, $message);
    }

    /**
     * Send notification about registration status.
     */
    public function sendRegistrationStatus(string $target, string $eventName, string $status): array
    {
        $statusText = $status === 'diterima' ? 'DITERIMA ✅' : 'DITOLAK ❌';
        $message = "*HIMANIKKA - Status Pendaftaran*\n\n";
        $message .= "Acara: *{$eventName}*\n";
        $message .= "Status: *{$statusText}*\n\n";
        $message .= "Login untuk melihat detail.\n";
        $message .= "— HIMANIKKA UPTT";

        return $this->sendMessage($target, $message);
    }

    /**
     * Send reminder about upcoming event.
     */
    public function sendEventReminder(string $target, string $eventName, string $date, string $place): array
    {
        $message = "*HIMANIKKA - Pengingat Acara*\n\n";
        $message .= "Acara: *{$eventName}*\n";
        $message .= "Tanggal: {$date}\n";
        $message .= "Tempat: {$place}\n\n";
        $message .= "Jangan lupa hadir!\n";
        $message .= "— HIMANIKKA UPTT";

        return $this->sendMessage($target, $message);
    }

    /**
     * Check account balance / quota.
     */
    public function checkBalance(): array
    {
        if (empty($this->apiKey)) {
            return ['status' => false, 'message' => 'API key not configured'];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->get("{$this->baseUrl}/balance");

            return $response->successful()
                ? ['status' => true, 'data' => $response->json()]
                : ['status' => false, 'message' => $response->body()];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
