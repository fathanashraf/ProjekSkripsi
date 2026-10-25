<?php

namespace App\Notifications;

use App\Models\Acara;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcaraApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public Acara $acara, public string $status) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusText = $this->status === 'approved' ? 'Disetujui ✅' : 'Ditolak ❌';
        $message = (new MailMessage)
            ->subject("Acara {$this->acara->name_acara} - {$statusText}")
            ->greeting("Halo {$notifiable->name}!")
            ->line("Acara **{$this->acara->name_acara}** telah **{$statusText}**.")
            ->line('Tanggal: ' . ($this->acara->tanggal?->format('d F Y') ?? '-'))
            ->line('Tempat: ' . ($this->acara->tempat ?? '-'));

        if ($this->status === 'approved') {
            $message->line('Silakan lanjutkan persiapan acara.')
                ->action('Lihat Acara', route('admin.acara.index'));
        } else {
            $message->line('Silakan ajukan ulang jika diperlukan.');
        }

        return $message->line('Terima kasih.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'acara_id' => $this->acara->id,
            'name_acara' => $this->acara->name_acara,
            'status' => $this->status,
            'message' => "Acara {$this->acara->name_acara} telah " .
                ($this->status === 'approved' ? 'disetujui' : 'ditolak'),
        ];
    }
}
