<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spj;
use App\Models\Tahap1;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $jumlahSpj = Spj::count();
        $jumlahUmkm = Tahap1::count();
        
        return view('auth.user', compact('user','jumlahSpj','jumlahUmkm'));
    }

}
