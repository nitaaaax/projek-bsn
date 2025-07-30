<?php

namespace App\Http\Controllers;

use App\Models\{Tahap1, Tahap2, Tahap3, Tahap4, Tahap5, Tahap6};
use Illuminate\Http\Request;



class UMKMSertifikasiController extends Controller
{
    public function index()
    {
        $tahap1 = Tahap1::where('status', 'Tersertifikasi')->get();
        return view('umkm.sertifikasi.index', compact('tahap1'));
    }
    public function destroy($id)
{
    $umkm = Tahap1::findOrFail($id);
    $umkm->delete();

    return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data UMKM berhasil dihapus.');
}
public function edit($id)
{
    $tahap = Tahap1::with(['tahap2', 'tahap3', 'tahap4', 'tahap5', 'tahap6'])->findOrFail($id);
    return view('umkm.sertifikasi.edit', compact('tahap'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_pelaku' => 'required|string|max:255',
        'produk' => 'required|string|max:255',
        'status_pembinaan' => 'required|string|max:255',
    ]);

    $umkm = Tahap1::findOrFail($id);
    $umkm->update([
        'nama_pelaku' => $request->nama_pelaku,
        'produk' => $request->produk,
        'status' => $request->status_pembinaan, // simpan ke kolom `status`
    ]);

    return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data berhasil diperbarui.');
}



}
