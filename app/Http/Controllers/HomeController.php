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

        return view('home', compact('jumlahSpj', 'jumlahUmkm'));
    } 
}
