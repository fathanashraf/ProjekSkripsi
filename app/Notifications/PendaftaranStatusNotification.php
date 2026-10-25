<?php

namespace App\Notifications;

use App\Models\Pendaftaran;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendaftaranStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public Pendaftaran $pendaftaran, public string $status) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusText = $this->status === 'diterima' ? 'Diterima ✅' : 'Ditolak ❌';

        return (new MailMessage)
            ->subject("Pendaftaran - {$statusText}")
            ->greeting("Halo {$notifiable->name}!")
            ->line('Pendaftaran Anda untuk acara **' . ($this->pendaftaran->acaras?->name_acara ?? '-') . '** telah **' . $statusText . '**.')
            ->action('Lihat Status', route('Mahasiswa.pendaftaran.index'))
            ->line('Terima kasih telah mendaftar.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pendaftaran_id' => $this->pendaftaran->id,
            'acara' => $this->pendaftaran->acaras?->name_acara,
            'status' => $this->status,
            'message' => "Pendaftaran Anda {$this->pendaftaran->acaras?->name_acara} telah {$this->status}",
        ];
    }
}
