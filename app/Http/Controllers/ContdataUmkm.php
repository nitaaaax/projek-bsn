<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use Illuminate\Http\Request;

class ContdataUmkm extends Controller
{
    /** Daftar semua pelaku (tahap 1) */
    public function index()
    {
        $tahap1 = Tahap1::all();
        return view('umkm.index', compact('tahap1'));
    }

    /** Detail satu UMKM + relasi (opsional) */
    public function show($id)
    {
        $tahap = Tahap1::with(['tahap2', 'tahap3', 'tahap4', 'tahap5', 'tahap6'])
                      ->findOrFail($id);

        return view('umkm.show', compact('tahap'));
    }
}
