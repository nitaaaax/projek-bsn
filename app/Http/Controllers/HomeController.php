<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\Tahap1;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $jumlahSpj = Spj::count();
        $jumlahUmkm = Tahap1::count();
        $role = auth()->user()->role->name; // pastikan ini tidak null

        // Arahkan ke view berdasarkan role
        if ($role == 'admin') {
            return view('role.admin', compact('jumlahSpj', 'jumlahUmkm'));
        } else {
            return view('role.user', compact('jumlahSpj', 'jumlahUmkm'));
        }
    }
}
