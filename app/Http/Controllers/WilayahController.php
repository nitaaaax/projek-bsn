<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function getKota($provinsi)
    {
        $kota = DB::table('kota')
                  ->where('provinsi', $provinsi)
                  ->select('id', 'nama_kota')
                  ->get();

        return response()->json($kota);
    }
}
