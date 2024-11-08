<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class CustomEmailVerification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Membuat URL verifikasi email
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Alamat Email Anda')
            ->greeting('Halo!')
            ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda. Verifikasi email hanya berlaku 60 menit dari sekarang.')
            ->action('Verifikasi Email', $verificationUrl)
            ->line('Jika Anda tidak membuat akun, abaikan email ini.');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verify.email.request',
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }
}
