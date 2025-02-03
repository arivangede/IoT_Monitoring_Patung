<?php

namespace App\Notifications;

use App\Models\EmailReceiver;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class NotificationEmailVerification extends Notification
{

    protected $receiver;

    /**
     * Buat instance Notification baru.
     *
     * @param  EmailReceiver  $receiver
     */
    public function __construct(EmailReceiver $receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * Tentukan channel notifikasi.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build pesan email.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Membuat URL verifikasi dengan hash dari email_address
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email')
            ->greeting('Halo!')
            ->line('Silakan klik tautan di bawah ini untuk memverifikasi email Anda, selanjutnya anda akan dapat menerima email dari sistem kami:')
            ->action('Verifikasi Akun', $verificationUrl)
            ->line('Jika Anda tidak meminta verifikasi ini, abaikan email ini.')
        ;
    }

    /**
     * Membuat URL verifikasi dengan hash dari email_address
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'email.receiver.verify', // Pastikan route ini sudah terdaftar
            Carbon::now()->addMinutes(60), // Tautan berlaku selama 60 menit
            ['id' => $this->receiver->id, 'hash' => sha1($this->receiver->email_address)]
        );
    }
}
