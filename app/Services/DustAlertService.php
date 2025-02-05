<?php

namespace App\Services;

use App\Models\EmailHistory;
use App\Models\Iot;
use App\Models\EmailReceiver;
use App\Notifications\DustAlertNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class DustAlertService
{
    public function checkAndSendEmail()
    {
        // Ambil data 1 jam terakhir
        $readings = Iot::whereBetween('created_at', [now()->subHour(), now()])->get();

        // Hitung rata-rata nilai dust_1 dan dust_2
        $averageDust1 = $readings->avg('dust_1');
        $averageDust2 = $readings->avg('dust_2');

        // Threshold
        $threshold = 1.0;

        // Cek apakah salah satu atau kedua sensor melebihi threshold
        if ($averageDust1 > $threshold || $averageDust2 > $threshold) {
            // Cek dan kirim email
            $lastRun = cache('dust_alert_last_run');
            $currentHour = now()->subHour()->format('Y-m-d H:00:00');

            // Ambil daftar email penerima yang aktif
            $receivers = EmailReceiver::where('status', 'Aktif')->get();
            $emails = $receivers->pluck('email_address')->toArray();

            // Cek dan kirim notifikasi untuk dust_1
            if ($averageDust1 > $threshold && (!$lastRun || $lastRun < $currentHour)) {
                Notification::route('mail', $emails)
                    ->notify(new DustAlertNotification('Sensor Dust 1', $averageDust1));

                foreach ($receivers as $receiver) {
                    EmailHistory::create([
                        'email_receiver_id' => $receiver->id,
                        'title' => "Notifikasi Debu Sensor Dust 1",
                        'text' => "Sensor Dust 1 dalam 1 jam terakhir mendapatkan nilai rata-rata {$averageDust1} mg/m³, dimana threshold adalah 1.0 mg/m³",
                        'status' => 'Terkirim',
                    ]);
                }
            }

            // Cek dan kirim notifikasi untuk dust_2
            if ($averageDust2 > $threshold && (!$lastRun || $lastRun < $currentHour)) {
                Notification::route('mail', $emails)
                    ->notify(new DustAlertNotification('Sensor Dust 2', $averageDust2));

                foreach ($receivers as $receiver) {
                    EmailHistory::create([
                        'email_receiver_id' => $receiver->id,
                        'title' => "Notifikasi Debu Sensor Dust 2",
                        'text' => "Sensor Dust 2 dalam 1 jam terakhir mendapatkan nilai rata-rata {$averageDust2} mg/m³, dimana threshold adalah 1.0 mg/m³",
                        'status' => 'Terkirim',
                    ]);
                }
            }

            // Update cache dengan waktu terakhir notifikasi dikirim
            cache(['dust_alert_last_run' => $currentHour], now()->addHour());
        } else {
            Log::info('Tidak ada notifikasi yang dikirim karena nilai rata-rata sensor tidak melebihi threshold.');
        }
    }
}