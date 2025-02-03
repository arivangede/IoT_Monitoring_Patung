<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DustAlertNotification extends Notification
{

    public $sensorName;
    public $averageDust;

    /**
     * Create a new notification instance.
     */
    public function __construct($sensorName, $averageDust)
    {
        $this->sensorName = $sensorName;
        $this->averageDust = $averageDust;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Peringatan: Rata-rata Debu Melebihi Threshold ({$this->sensorName})")
            ->greeting('Peringatan!')
            ->line("Rata-rata nilai debu dari {$this->sensorName} dalam 1 jam terakhir adalah: {$this->averageDust}.")
            ->line("Nilai ini melebihi batas threshold yang ditentukan (100 mg/m³), mohon untuk melakukan pengecekan pada kebersihan bilik " . $this->getCompartmentNumber($this->sensorName) . ".");
    }

    private function getCompartmentNumber($sensorName)
    {
        switch ($sensorName) {
            case 'Sensor Dust 1':
                return '1';
            case 'Sensor Dust 2':
                return '2';
            default:
                return 'unknown';
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
