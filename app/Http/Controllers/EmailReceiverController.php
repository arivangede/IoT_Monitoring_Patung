<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Models\EmailHistory;
use App\Models\EmailReceiver;
use App\Notifications\NotificationEmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class EmailReceiverController extends Controller
{
    public function getAll()
    {
        $receivers = EmailReceiver::all();

        return response()->json($receivers);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'email_address' => 'required|email|unique:email_receivers,email_address',
        ], [
            'email_address.email' => 'Alamat email harus berupa alamat email yang valid',
            'email_address.unique' => 'Alamat email ini sudah terdaftar',
        ]);

        // Sanitasi email address
        $email = filter_var($validated['email_address'], FILTER_SANITIZE_EMAIL);

        // Validasi ulang setelah sanitasi
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors('Alamat email yang disanitasi tidak valid.');
        }

        // Membuat model EmailReceiver
        $receiver = EmailReceiver::create([
            'email_address' => $email,
            'status' => 'menunggu verifikasi',
        ]);

        try {
            // Mengirimkan notifikasi verifikasi
            $receiver->notify(new NotificationEmailVerification($receiver));

            // Menyimpan log pengiriman notifikasi
            EmailHistory::create([
                'email_receiver_id' => $receiver->id,
                'title' => 'Email Verifikasi',
                'text' => 'Email verifikasi untuk akun baru.',
                'status' => 'Terkirim',
            ]);
        } catch (\Exception $e) {
            // Jika pengiriman gagal, perbarui status receiver
            $receiver->update(['status' => 'gagal mengirimkan verifikasi']);

            // Menyimpan log pengiriman gagal
            EmailHistory::create([
                'email_receiver_id' => $receiver->id,
                'title' => 'Email Verifikasi',
                'text' => 'Email verifikasi untuk akun baru.',
                'status' => 'Gagal: ' . $e->getMessage(),
            ]);

            // Mengembalikan error ke user
            return back()->withErrors('Terjadi kesalahan saat mengirim email verifikasi. Silakan coba lagi.');
        }

        // Jika berhasil, kirimkan pesan sukses
        return back()->with('success', 'Alamat email berhasil terdaftar, verifikasi email sudah dikirimkan.');
    }

    public function resendVerificationEmail($id)
    {
        $receiver = EmailReceiver::findOrFail($id);

        // Pastikan email belum aktif
        if ($receiver->status === 'active') {
            return response()->json([
                'message' => 'Alamat email ini sudah diverifikasi.'
            ], 400);
        }

        // Mengirimkan email verifikasi ulang
        Mail::to($receiver->email_address)->send(new VerificationEmail($receiver));

        // Menyimpan history email
        EmailHistory::create([
            'email_receiver_id' => $receiver->id,
            'title' => 'Resend Email Verifikasi',
            'text' => 'Resend email verifikasi.',
            'status' => 'Terkirim',
        ]);

        return response()->json([
            'message' => 'Email verifikasi berhasil dikirim ulang.'
        ]);
    }


    public function verifyEmail($id)
    {
        $receiver = EmailReceiver::findOrFail($id);

        $receiver->update([
            'email_verified_at' => now(),
            'status' => 'Aktif',
        ]);

        return Inertia::render('Notification/EmailVerified');
    }

    public function destroy($id)
    {
        $receiver = EmailReceiver::findOrFail($id);
        $receiver->delete();

        return back()->with('success', 'Alamat email berhasil dihapus.');
    }
}
