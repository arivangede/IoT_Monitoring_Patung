<?php

namespace App\Services;

use App\Models\Iot;
use App\Models\EmailReceiver;
use App\Notifications\DustAlertNotification;
use Illuminate\Support\Facades\Notification;

class DustAlertService
{
    public function checkAndSendEmail()
    {
        // Ambil data 1 jam terakhir
        $readings = Iot::whereBetween('created_at', [now()->subHour(), now()])->get();

        // \Log::info('Processing data for the hour: ' . now()->startOfHour()->subHour()->toDateTimeString() . ' to ' . now()->startOfHour()->toDateTimeString());

        // Hitung rata-rata nilai dust_1 dan dust_2
        $averageDust1 = $readings->avg('dust_1');
        $averageDust2 = $readings->avg('dust_2');

        // Threshold (misalnya 100)
        $threshold = 0.1;

        // Ambil daftar email penerima yang aktif
        $emails = EmailReceiver::where('status', 'Aktif')->pluck('email_address')->toArray();

        // Cek dan kirim email untuk dust_1
        if ($averageDust1 >= $threshold) {
            Notification::route('mail', $emails)
                ->notify(new DustAlertNotification('Sensor Dust 1', $averageDust1));
        }

        // Cek dan kirim notifikasi untuk dust_2
        if ($averageDust2 >= $threshold) {
            Notification::route('mail', $emails)
                ->notify(new DustAlertNotification('Sensor Dust 2', $averageDust2));
        }
    }
}