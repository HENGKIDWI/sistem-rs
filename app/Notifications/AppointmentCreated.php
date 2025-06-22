<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCreated extends Notification
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Kita akan simpan notifikasi di database
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Janji Temu Dibuat',
            'message' => 'Janji temu Anda dengan Dr. ' . $this->appointment->dokter->nama_lengkap . ' pada tanggal ' . $this->appointment->tanggal_kunjungan->format('d M Y') . ' telah berhasil dibuat.',
            'url' => route('pasien.dashboard'), // Arahkan ke dashboard pasien
        ];
    }
}
