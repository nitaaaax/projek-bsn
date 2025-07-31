<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spj;
use App\Models\Tahap1;

class HomeController extends Controller
{
    public function index()
    {
        $jumlahSpj = Spj::count();
        $jumlahUmkm = Tahap1::count();
        $user = auth()->user();

        return view('home', [
            'jumlahSpj' => $jumlahSpj,
            'jumlahUmkm' => $jumlahUmkm,
            'role' => $user->role->name ?? 'user',
            'user' => $user
        ]);
    }
}
