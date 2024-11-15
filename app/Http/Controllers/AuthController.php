<?php

namespace App\Http\Controllers;


use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\CustomEmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function showRegisterForm()
    {
        return Inertia::render('Auth/Register');
    }

    public function register(RegisterRequest $request)
    {
        // Membuat user baru dengan data yang sudah divalidasi
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
        ]);

        Auth::login($user);

        $user->sendCustomEmailVerificationNotification();

        // Redirect ke login
        return redirect()->route('verify.email.notice')->with('success', 'Registrasi berhasil, Cek email anda sekarang untuk verifikasi email.');
    }

    public function verifyindex()
    {
        return Inertia::render('Auth/VerifyEmail');
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email Anda sudah diverifikasi.');
        }

        try {
            $user->notify(new CustomEmailVerification());
            return back()->with('success', 'Email verifikasi telah dikirim ulang!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengirim email verifikasi, coba lagi nanti.']);
        }

    }

    public function verify(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        if ($user->markEmailAsVerified()) {
            return redirect()->route('dashboard')->with('success', 'Verifikasi email berhasil!');
        }

        return redirect()->route('verify.email.notice')->withErrors(['error' => 'Verifikasi email gagal, mohon untuk coba request verifikasi baru.']);
    }

    public function forgotIndex()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function forgotSend(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return back()->withErrors(['error' => 'Alamat email ini tidak ada dalam catatan pengguna kami.']);
        }

        $status = Password::sendResetLink($validatedData);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Link reset password telah dikirim ke email anda');
        } elseif ($status === Password::RESET_THROTTLED) {
            return back()->withErrors(['error' => 'Anda baru saja dikirimkan link reset password, mohon tunggu sebelum melakukan kirim ulang lagi']);
        } else {
            return back()->withErrors(['error' => 'Gagal mengirim link reset password, coba lagi nanti']);
        }
    }

    public function resetPasswordIndex(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        return Inertia::render('Auth/ResetPassword', [
            'token' => $token,
            'email' => $email,
        ]);

    }

    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate(
            [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'password.min' => 'Password harus 8 karakter atau lebih'
            ]
        );

        $status = Password::reset(
            $validatedData,
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password berhasil direset, silakan login.');
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Mencoba login dengan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            // Jika login berhasil, redirect ke dashboard
            $request->session()->regenerate(); // Regenerasi session untuk keamanan
            return redirect()->route('dashboard')->with('success', 'Login berhasil.');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'error' => 'Username atau Password Salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user

        $request->session()->invalidate(); // Menghapus session
        $request->session()->regenerateToken(); // Regenerasi CSRF token

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
