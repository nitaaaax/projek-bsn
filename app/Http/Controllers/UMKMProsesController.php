<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use Illuminate\Http\Request;

class UMKMProsesController extends Controller
{
    public function index()
    {
        $tahap1 = Tahap1::where('status', '!=', 'Tersertifikasi')->get();
        return view('umkm.proses.index', compact('tahap1'));
    }

    public function sertifikasi($id)
    {
        $umkm = Tahap1::findOrFail($id);
        $umkm->status = 'Tersertifikasi';
        $umkm->save();

        return redirect()->route('umkm.proses.index')->with('success', 'UMKM berhasil disertifikasi!');
    }
}
