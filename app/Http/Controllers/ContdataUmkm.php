<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahap1;

use App\Models\Tahap2;

use App\Models\Tahap3;

use App\Models\Tahap4;

use App\Models\Tahap5;

use App\Models\Tahap6;


class ContdataUmkm extends Controller
{
     public function index()
    {
        $tahap1 = Tahap1::all();
        
        return view('umkm.index', compact('tahap1'));
    }
        
}
