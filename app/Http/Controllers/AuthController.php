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

    public function showRegister()
    {
        return view('auth.register');
    }

    public function home()
    {
        $jumlahSpj = Spj::count();
        $jumlahUmkm = Tahap1::count();
        $role = auth()->user()->role->name; // 'admin' atau 'user'

        return view('home', compact('role', 'jumlahSpj', 'jumlahUmkm'));
    }


    public function processRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required|in:1,2', // 1 = admin, 2 = user
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $roleName = auth()->user()->role->name; // 'admin' / 'user'

            return redirect()->route("$roleName.home")->with('success', 'Selamat datang!');
        }

        return back()->withErrors(['email' => 'Login gagal']);
    }

    public function logout(Request $request)
    {
        session()->forget('user');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
