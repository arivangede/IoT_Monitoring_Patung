<?php

namespace App\Http\Controllers;


use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

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
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
        ]);

        // Redirect ke login
        return redirect()->route('login')->with('success', 'Registrasi berhasil, Silahkan login.');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Mencoba login dengan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            // Jika login berhasil, redirect ke dashboard
            $request->session()->regenerate(); // Regenerasi session untuk keamanan
            return redirect()->intended(route('dashboard'))->with('success', 'Login berhasil.');
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

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
