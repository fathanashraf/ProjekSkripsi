<?php

namespace App\Notifications;

use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PembayaranConfirmedNotification extends Notification
{
    use Queueable;

    public function __construct(public Pembayaran $pembayaran) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pembayaran Dikonfirmasi ✅')
            ->greeting("Halo {$notifiable->name}!")
            ->line('Pembayaran Anda untuk acara **' . ($this->pembayaran->acara?->name_acara ?? '-') . '** telah dikonfirmasi.')
            ->line("Status: **LUNAS**")
            ->action('Lihat Detail', route('Mahasiswa.pembayaran.index'))
            ->line('Terima kasih.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pembayaran_id' => $this->pembayaran->id,
            'acara' => $this->pembayaran->acara?->name_acara,
            'status' => 'lunas',
            'message' => "Pembayaran {$this->pembayaran->acara?->name_acara} telah dikonfirmasi",
        ];
    }
}
