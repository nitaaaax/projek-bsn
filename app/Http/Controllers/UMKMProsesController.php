<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Provinsi;
use App\Models\Kota;

class UMKMProsesController extends Controller
{
    public function index(Request $request)
    {

        $tahap1= Tahap1::where('status_pembinaan','!=','SPPT SNI')->get(); 

        return view('umkm.proses.index', compact('tahap1'));
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $tahap1 = Tahap1::findOrFail($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

            // Validasi Tahap 1
            $validated1 = $request->validate([
                'nama_pelaku' => 'nullable|string|max:255',
                'produk' => 'nullable|string|max:255',
                'klasifikasi' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:255',
                'pembina_1' => 'nullable|string|max:255',
                'pembina_2' => 'nullable|string|max:255',
                'sinergi' => 'nullable|string|max:255',
                'nama_kontak_person' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string|max:25',
                'bulan_pertama_pembinaan' => 'required',
                'tahun_dibina' => 'nullable|string|max:4',
                'riwayat_pembinaan' => 'nullable|string',
                'status_pembinaan' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'media_sosial' => 'nullable|string|max:255',
                'nama_merek' => 'nullable|string|max:255',
                'lspro' => 'nullable|string|max:255',
                'jenis_usaha' => 'nullable|string|max:255',
                'tanda_daftar_merk' => 'nullable|string|max:255',
            ]);

            // Validasi Tahap 2
            $validated2 = $request->validate([
                'omzet' => 'nullable|numeric',
                'volume_per_tahun' => 'nullable|string|max:255',
                'jumlah_tenaga_kerja' => 'nullable|integer',
                'tahun_pendirian' => 'nullable|string|max:4',
                'alamat_kantor' => 'nullable|string|max:255',
                'provinsi_kantor' => 'nullable|string|max:255',
                'kota_kantor' => 'nullable|string|max:255',
                'alamat_pabrik' => 'nullable|string|max:255',
                'provinsi_pabrik' => 'nullable|string|max:255',
                'kota_pabrik' => 'nullable|string|max:255',
                'link_dokumen' => 'nullable|url|max:255',
                'sni_yang_diterapkan' => 'nullable|string',
                'gruping' => 'nullable|string|max:255',
            ]);

            // Handle array fields → JSON
            $legalitas = $request->input('legalitas_usaha', []);
            if ($request->filled('legalitas_usaha_lainnya')) {
                $legalitas[] = $request->legalitas_usaha_lainnya;
            }
            $validated2['legalitas_usaha'] = json_encode(array_filter($legalitas));
            $validated2['sertifikat'] = json_encode($request->input('sertifikat', []));
            $validated2['jangkauan_pemasaran'] = json_encode($request->input('jangkauan_pemasaran', []));

            // Legalitas
            $legalitas = $request->input('legalitas_usaha', []);
            if (in_array('lainnya', $legalitas) && $request->filled('legalitas_usaha_lainnya')) {
                $legalitas = array_diff($legalitas, ['lainnya']);
                $legalitas[] = $request->legalitas_usaha_lainnya;
            }
            $validated2['legalitas_usaha'] = json_encode(array_filter($legalitas));

            // Sertifikat
            $sertifikat = $request->input('sertifikat', []);
            if (in_array('lainnya', $sertifikat) && $request->filled('sertifikat_lainnya')) {
                $sertifikat = array_diff($sertifikat, ['lainnya']);
                $sertifikat[] = $request->sertifikat_lainnya;
            }
            $validated2['sertifikat'] = json_encode(array_filter($sertifikat));

            // Instansi
            $instansiFinal = [];
            foreach ($request->input('instansi_check', []) as $key) {
                $instansiFinal[$key] = $request->input("instansi_detail.$key", '');
            }
            $validated2['instansi'] = json_encode($instansiFinal);

            // jangkauan pemsaran
            $jangkauanFinal = [];
            foreach ($request->input('jangkauan_pemasaran', []) as $key) {
                if ($key === 'Lainnya' && $request->filled('jangkauan_pemasaran_lainnya')) {
                    $jangkauanFinal[$key] = $request->jangkauan_pemasaran_lainnya;
                } else {
                    $jangkauanFinal[$key] = $request->input("jangkauan_detail.$key", '');
                }
            }
            $validated2['jangkauan_pemasaran'] = json_encode($jangkauanFinal);

            // Foto Produk
            $fotoProduk = json_decode($tahap2->foto_produk ?? '[]', true);
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    $fotoProduk[] = $file->store('uploads/foto_produk', 'public');
                }
            }
            $validated2['foto_produk'] = json_encode($fotoProduk);

            // Foto Tempat Produksi
            $fotoTempat = json_decode($tahap2->foto_tempat_produksi ?? '[]', true);
            if ($request->hasFile('foto_tempat_produksi')) {
                foreach ($request->file('foto_tempat_produksi') as $file) {
                    $fotoTempat[] = $file->store('uploads/foto_tempat', 'public');
                }
            }
            $validated2['foto_tempat_produksi'] = json_encode($fotoTempat);

            // Update database
            $tahap1->update($validated1);
            $tahap2->update($validated2);
        });

        return redirect()->route('umkm.proses.index')->with('success', 'Data UMKM berhasil diperbarui.');
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

        return view('admin.umkm.tahap.form', compact(
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

    public function show($id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        $jangkauan = ['Lokal', 'Regional', 'Nasional', 'Internasional'];

        return view('umkm.show', compact('tahap1', 'tahap2', 'jangkauan'));
    }

    public function destroy($id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        if ($tahap2) {
            // Hapus file foto_produk
            $fotoProduk = json_decode($tahap2->foto_produk, true);
            if (is_array($fotoProduk)) {
                foreach ($fotoProduk as $file) {
                    $path = public_path("storage/" . $file);
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }

            // Hapus file foto_tempat_produksi
            $fotoTempat = json_decode($tahap2->foto_tempat_produksi, true);
            if (is_array($fotoTempat)) {
                foreach ($fotoTempat as $file) {
                    $path = public_path("storage/" . $file);
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }

            $tahap2->delete();
        }

        $tahap1->delete();

        return redirect()->route('umkm.proses.index')->with('success', 'Data berhasil dihapus.');
    }

    public function showUser($id){
    $tahap1 = Tahap1::findOrFail($id);
    $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

    return view('user.showuser', compact('tahap1', 'tahap2'));
    }

    private function mergeOldWithNewFiles($request, $oldFiles, $fieldName)
    {
        $files = $request->file($fieldName, []);
        $merged = [];

        // Tambah file lama yang tidak dihapus
        $removed = explode(',', $request->input("removed_{$fieldName}", ''));

        foreach ($oldFiles as $old) {
            $filename = basename($old);
            if (!in_array($filename, $removed)) {
                $merged[] = $old;
            }
        }


        // Upload file baru jika ada
        foreach ((array) $files as $file) {
            if ($file) {
                $path = $file->store("uploads/{$fieldName}", 'public');
                $merged[] = $path;
            }
        }

        return $merged;
    }

    private function uploadFiles(Request $request, $field)
    {
        $paths = [];
        if ($request->hasFile($field)) {
            foreach ($request->file($field) as $file) {
                if ($file && $file->isValid()) {
                    $filename = Str::random(10) . '_' . $file->getClientOriginalName();
                    $file->storeAs("uploads/{$field}", $filename, 'public');
                    $paths[] = $filename;
                }
            }
        }
        return $paths;
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
