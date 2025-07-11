<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;

class UMKMSertifikasiController extends Controller
{
    public function index()
    {
        $tahap1 = Tahap1::where('status', 'Tersertifikasi')->get();
        return view('umkm.sertifikasi.index', compact('tahap1'));
    }
    public function destroy($id)
{
    $umkm = \App\Models\Tahap1::findOrFail($id);
    $umkm->delete();

    return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data UMKM berhasil dihapus.');
}

}
