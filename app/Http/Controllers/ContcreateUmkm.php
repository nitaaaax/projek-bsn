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
        $tahap = Tahap1::count();
        return view('tahap.create', compact('tahap'));
    }

    public function create()
    {
    return redirect()->route('admin.umkm.create.tahap', ['tahap' => 1]);
    }
    

    public function showTahap(int $tahap, $id = null)
    {
        $data = null;
        if ($tahap == 1) {
            $data = Tahap1::find($id);
        } elseif ($tahap == 2) {
            $data = Tahap2::where('pelaku_usaha_id', $id)->first();
        } else {
            abort(404, 'Tahap tidak valid.');
        }

        return view('tahap.create', [
            'tahap' => $tahap,
            'data' => $data,
            'id' => $id,
            'pelaku_usaha_id' => $id,
        ]);
    }

    public function store(Request $request, int $tahap, $id = null)
    {
        $isEdit = $id !== null;
        
        // dd($request->all());

        if ($tahap == 1) {
            if ($request->has('riwayat_pembinaan') && is_array($request->riwayat_pembinaan)) {
                $request->merge([
                    'riwayat_pembinaan' => implode(', ', $request->riwayat_pembinaan),
                ]);
            }

            $rules = [
                'nama_pelaku' => 'nullable|string|max:255',
                'produk' => 'nullable|string|max:255',
                'klasifikasi' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:50',
                'pembina_1' => 'nullable|string|max:255',
                'pembina_2' => 'nullable|string|max:255',
                'sinergi' => 'nullable|string|max:255',
                'nama_kontak_person' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string|max:25',
                'bulan_pertama_pembinaan' => 'nullable|string|max:10',
                'tahun_dibina' => 'nullable|string|max:4',
                'riwayat_pembinaan' => 'nullable|string',
                'status_pembinaan' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'media_sosial' => 'nullable|string|max:255',
                'nama_merek' => 'nullable|string|max:255',
                'lspro' => 'nullable|string|max:255',
                'tanda_daftar_merk' => 'nullable|string|max:255',
            ];

            $validated = $request->validate($rules);

            if ($isEdit) {
                Tahap1::findOrFail($id)->update($validated);
                $nextId = $id;
            } else {
                $tahap1 = Tahap1::create($validated);
                $nextId = $tahap1->id;
            }

            return redirect()->route('admin.umkm.create.tahap', [
                'tahap' => 2,
                'id' => $nextId
            ])->with('success', 'Tahap 1 berhasil disimpan');
        }

        if ($tahap == 2) {
            $pelaku_usaha_id = $isEdit ? $request->pelaku_usaha_id : $id;
            $request->merge([
                'jangkauan_pemasaran' => is_array($request->jangkauan_pemasaran) ? $request->jangkauan_pemasaran : (array) $request->jangkauan_pemasaran
            ]);

            $rules = [
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
                'instansi' => 'nullable|string|max:255',
                'legalitas_usaha' => 'nullable|string|max:255',
                'tahun_pendirian' => 'nullable|string|max:4',
                'foto_produk.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'foto_tempat_produksi.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'jenis_usaha' => 'nullable|in:Pangan,Nonpangan',
                'sni_yang_diterapkan' => 'nullable|string',
                'sertifikat' => 'nullable|string',
            ];

                $validated = $request->validate($rules);
                $validated['pelaku_usaha_id'] = $pelaku_usaha_id; // Ensure this is included

                // Handle file uploads
                $foto_produk_paths = [];
                if ($request->hasFile('foto_produk')) {
                    foreach ($request->file('foto_produk') as $file) {
                        if ($file->isValid()) {
                            $filename = 'produk_'.time().'_'.Str::random(5).'.'.$file->getClientOriginalExtension();
                            $path = $file->storeAs('public/uploads/foto_produk', $filename);
                            $foto_produk_paths[] = str_replace('public/', '', $path);
                        }
                    }
                }

                $foto_tempat_produksi_paths = [];
                if ($request->hasFile('foto_tempat_produksi')) {
                    foreach ($request->file('foto_tempat_produksi') as $file) {
                        if ($file->isValid()) {
                            $filename = 'tempat_'.time().'_'.Str::random(5).'.'.$file->getClientOriginalExtension();
                            $path = $file->storeAs('public/uploads/foto_tempat_produksi', $filename);
                            $foto_tempat_produksi_paths[] = str_replace('public/', '', $path);
                        }
                    }
                }

                // Now safely use $pelaku_usaha_id since it's been assigned
                $validated['foto_produk'] = !empty($foto_produk_paths) 
                    ? json_encode($foto_produk_paths) 
                    : ($isEdit ? Tahap2::where('pelaku_usaha_id', $pelaku_usaha_id)->value('foto_produk') : json_encode([]));
                
                $validated['foto_tempat_produksi'] = !empty($foto_tempat_produksi_paths) 
                    ? json_encode($foto_tempat_produksi_paths) 
                    : ($isEdit ? Tahap2::where('pelaku_usaha_id', $pelaku_usaha_id)->value('foto_tempat_produksi') : json_encode([]));

                if ($isEdit) {
                    Tahap2::updateOrCreate(['pelaku_usaha_id' => $pelaku_usaha_id], $validated);
                } else {
                    Tahap2::create($validated);
                }

                return redirect()->route('umkm.proses.index')->with('success', 'Tahap 2 berhasil disimpan');
            }
        
        abort(404, 'Tahap tidak valid.');
    }

    public function destroy($id)
    {
        // Hapus data tahap 1 dan tahap 2 (jika pakai relasi pelaku_usaha_id)
        $tahap1 = Tahap1::findOrFail($id);
        
        // Jika ada tahap2 terkait
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();
        if ($tahap2) {
            $tahap2->delete();
        }

        $tahap1->delete();

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil dihapus.');
    }
    public function show($id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        // Pastikan view 'umkm.sertifikasi.show' ada
        if (!view()->exists('umkm.sertifikasi.show')) {
            abort(404, "View 'umkm.sertifikasi.show' not found.");
        }

        return view('umkm.sertifikasi.show', compact('tahap1', 'tahap2'));
    }



}