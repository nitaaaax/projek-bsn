<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Spj;
use App\Models\Tahap1;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function home()
    {
        $jumlahSpj = Spj::count();
        $jumlahUmkm = Tahap1::count();
        $role = auth()->user()->role->name; // 'admin' atau 'user'

        return view('home', compact('role', 'jumlahSpj', 'jumlahUmkm'));
    }

    public function processLogin(Request $request)
    {
        // Validasi input email dan password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan'])->withInput();
        }

        // Cek password menggunakan Hash::check()
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah'])->withInput();
        }

        // Login user secara manual
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Redirect ke home dengan pesan sukses
        return redirect()->route('home')->with('success', 'Login berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
