<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Tahap1;
use App\Models\Tahap2;

class ContcreateUmkm extends Controller
{
    public function index()
    {
        $data = Tahap1::with('tahap2')->first();
        $tahap = 1;

        return view('tahap.create', [
            'tahap' => $tahap,
            'pelaku_usaha_id' => $data->id ?? null,
            'id' => $data->id ?? null,
            'tahapNumber' => $tahap,
            'data' => $data
        ]);
    }

    public function create()
    {
        return redirect()->route('admin.umkm.create.tahap', ['tahap' => 1]);
    }

    public function showTahap(int $tahap, $id = null)
    {
        if (!in_array($tahap, [1, 2])) {
            abort(404, 'Tahap tidak valid.');
        }

        $data = null;

        if ($tahap === 1) {
            $data = Tahap1::find($id);
        } elseif ($tahap === 2) {
            $data = Tahap2::where('pelaku_usaha_id', $id)->first();
        }

        return view('tahap.create', [
            'tahapNumber' => $tahap,
            'tahap' => $tahap,
            'data' => $data,
            'id' => $id,
            'pelaku_usaha_id' => $id,
        ]);
    }

    public function store(Request $request, int $tahap, $id = null)
    {

        //dd($request->all());

        if (!in_array($tahap, [1, 2])) {
            abort(404, 'Tahap tidak valid.');
        }

        // === Tahap 1 ===
        if ($tahap === 1) {
            $validated = $request->validate([
                'nama_pelaku' => 'nullable|string|max:255',
                'produk' => 'nullable|string|max:255',
                'klasifikasi' => 'nullable|string|max:255',
                'status' => 'nullable|in:masih dibina,drop/tidak dilanjutkan',
                'pembina_1' => 'nullable|string|max:255',
                'pembina_2' => 'nullable|string|max:255',
                'sinergi' => 'nullable|string|max:255',
                'nama_kontak_person' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string|max:25',
                'bulan_pertama_pembinaan' => 'required|in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember',
                'tahun_dibina' => 'nullable|string|max:4',
                'riwayat_pembinaan' => 'nullable|string',
                'status_pembinaan' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'media_sosial' => 'nullable|string|max:255',
                'nama_merek' => 'nullable|string|max:255',
                'lspro' => 'nullable|string|max:255',
                'jenis_usaha' => 'nullable|in:Pangan,Nonpangan',
                'tanda_daftar_merk' => 'nullable|string|max:255',
            ]);

            $tahap1 = Tahap1::create($validated);

            return redirect()->route('admin.umkm.create.tahap', [
                'tahap' => 2,
                'id' => $tahap1->id,
            ])->with('success', 'Tahap 1 berhasil disimpan.');
        }

        // === Tahap 2 ===
       if ($tahap === 2) {
            if (!$id || !Tahap1::find($id)) {
            abort(404, 'ID Tahap1 tidak ditemukan.');
            }              
            $validated = $request->validate([
                'omzet' => 'nullable|numeric',
                'volume_per_tahun' => 'nullable|string|max:255',
                'jumlah_tenaga_kerja' => 'nullable|integer',
                'jangkauan_pemasaran' => 'nullable|array',
                'jangkauan_pemasaran.*' => 'in:Local,Nasional,Internasional',
                'link_dokumen' => 'nullable|url|max:255',
                'alamat_kantor' => 'nullable|string|max:255',
                'provinsi_kantor' => 'nullable|string|max:255',
                'kota_kantor' => 'nullable|string|max:255',
                'alamat_pabrik' => 'nullable|string|max:255',
                'provinsi_pabrik' => 'nullable|string|max:255',
                'kota_pabrik' => 'nullable|string|max:255',
                'instansi_check' => 'nullable|array',
                'instansi_check.*' => 'string|in:Dinas,Kementerian,Perguruan Tinggi,Komunitas',
                'instansi_detail' => 'nullable|array',
                'instansi_detail.*' => 'nullable|string|max:255',
                'legalitas_usaha' => 'nullable|string|max:255',
                'tahun_pendirian' => 'nullable|string|max:4',
                'foto_produk.*' => 'nullable|image|max:20480', 
                'foto_tempat_produksi.*' => 'nullable|image|max:20480',
                'sni_yang_diterapkan' => 'nullable|string',
                'sertifikat' => 'nullable|string',
                'gruping' => 'nullable|string',
            ]);

            // Upload foto
            $foto_produk_paths = [];
            $foto_tempat_produksi_paths = [];

            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    if ($file->isValid()) {
                        $filename = 'produk_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('public/uploads/gambar_produk/', $filename);
                        $foto_produk_paths[] = str_replace('public/', '', $path);
                    }
                }
            }

            if ($request->hasFile('foto_tempat_produksi')) {
                foreach ($request->file('foto_tempat_produksi') as $file) {
                    if ($file->isValid()) {
                        $filename = 'tempat_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('public/uploads/foto_tempat_produksi', $filename);
                        $foto_tempat_produksi_paths[] = str_replace('public/', '', $path);
                    }
                }
            }

            $instansi = [];
            if ($request->filled('instansi_check')) {
                foreach ($request->input('instansi_check') as $key) {
                    $instansi[$key] = $request->input("instansi_detail.$key");
                }
            }
            $validated['instansi'] = json_encode($instansi);

            $validated['foto_produk'] = json_encode($foto_produk_paths);
            $validated['foto_tempat_produksi'] = json_encode($foto_tempat_produksi_paths);

            $validated['pelaku_usaha_id'] = $id; 

            Tahap2::create($validated);

            return redirect()->route('umkm.proses.index')->with('success', 'Data Tahap 2 berhasil disimpan.');
        }
    }
    
    public function destroy($id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        if ($tahap2) {
            $tahap2->delete();
        }

        $tahap1->delete();

        return redirect()->route('umkm.proses.index')->with('success', 'Data UMKM berhasil dihapus.');
    }

    public function show($id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        $jangkauan = ['Lokal', 'Regional', 'Nasional', 'Internasional'];

        return view('umkm.show', compact('tahap1', 'tahap2', 'jangkauan'));
    }
}
