<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Provinsi;
use App\Models\Kota;

class UMKMSertifikasiController extends Controller
{
    public function index(Request $request)
    {
        $items = Tahap1::where('status_pembinaan', 'SPPT SNI (TERSERTIFIKASI)')->get();

        return view('umkm.sertifikasi.index', compact('items'));
    }

    public function edit($id)
    {
        $tahap1 = Tahap1::with('tahap2')->findOrFail($id);
        $tahap2 = $tahap1->tahap2;

        $legalitasArray = [];
        $sertifikatArray = [];
        $jangkauanArray = [];
        $instansiArray = [];
        $foto_produk = [];
        $foto_tempat_produksi = [];

        if ($tahap2) {
            $legalitasArray = json_decode($tahap2->legalitas_usaha ?? '[]', true);
            $sertifikatArray = json_decode($tahap2->sertifikat ?? '[]', true);
            $jangkauanArray = json_decode($tahap2->jangkauan_pemasaran ?? '[]', true);
            $foto_produk = json_decode($tahap2->foto_produk ?? '[]', true);
            $foto_tempat_produksi = json_decode($tahap2->foto_tempat_produksi ?? '[]', true);
            $instansiArray = json_decode($tahap2->instansi ?? '[]', true);

        }

        return view('umkm.sertifikasi.edit', compact(
            'tahap1',
            'tahap2',
            'legalitasArray',
            'sertifikatArray',
            'jangkauanArray',
            'instansiArray',
            'foto_produk',
            'foto_tempat_produksi'
        ));
    }

    public function update(Request $request, $filename)
    {
        $filename = urldecode($filename);

        $request->validate([
            'file' => 'required|file|mimes:doc,docx,xls,xlsx|max:2048',
        ]);

        // Use storage path
        $path = storage_path('app/public/template/' . $filename);

        // Delete old file if exists
        if (file_exists($path)) {
            unlink($path);
        }

        // Store new file
        $request->file('file')->storeAs('public/template', $filename);

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil diperbarui.');
    }

    public function destroy($filename)
    {
        $filename = urldecode($filename);
        $path = storage_path('app/public/template/' . $filename);

        if (file_exists($path)) {
            unlink($path);
            return redirect()->route('admin.templates.index')->with('success', 'Template berhasil dihapus.');
        }

        return redirect()->route('admin.templates.index')->withErrors(['File tidak ditemukan.']);
    }

    public function getProvinsi()
    {
        $provinsi = Provinsi::select('id', 'nama')->get(); 
        return response()->json($provinsi);
    }

    public function getKota($provinsi_id)
    {
        $kota = Kota::where('provinsi_id', $provinsi_id)->get();
        return response()->json($kota);
    }

}