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
        $role = auth()->user()->role?->name; // pakai null-safe operator

        return view('home', compact('role', 'jumlahSpj', 'jumlahUmkm'));
    }

   public function processLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('home')->with('success', 'Login berhasil!');
    }

    return back()->with('error', 'Email atau password salah')->withInput();
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function profile()
    {
        $user = auth()->user();
        $role = auth()->user()->role->name; // 'admin' atau 'user'

        return view('auth.profile', compact('role', 'user'));
    }

}
