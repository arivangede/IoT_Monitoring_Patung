<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserSettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('UserSettings');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|min:6|max:30',
            'email' => 'string|email|unique:users'
        ], [
            'name.string' => 'Nama harus berupa huruf',
            'name.min' => 'Nama harus terdiri dari 6 karakter atau lebih',
            'name.max' => 'Nama maksimal hanya terdiri dari 30 karakter',

            'email.string' => 'Email harus berupa huruf',
            'email.email' => 'Email harus berupa alamat email yang valid',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain',
        ]);

        $user = User::findOrFail($id);
        $user->update($validatedData);

        return redirect(route('user-settings'))->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function change_password(Request $request, $id)
    {
        $validatedData = $request->validate([
            'oldPassword' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'oldPassword.required' => 'Password lama harus diisi',
            'oldPassword.string' => 'Password lama harus berupa teks',
            'password.required' => 'Password baru harus diisi',
            'password.string' => 'Password baru harus berupa teks',
            'password.min' => 'Password baru harus terdiri dari minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password baru',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($validatedData['oldPassword'], $user->password)) {
            return back()->withErrors(['error' => 'Password yang dimasukan tidak sesuai']);
        }

        $user->password = Hash::make($validatedData['password']);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui');
    }

    public function delete_account($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Akun berhasil dihapus dan telah logout');
    }
}
