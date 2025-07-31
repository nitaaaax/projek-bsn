<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $request->merge([
            'jangkauan_pemasaran' => is_array($request->jangkauan_pemasaran) ? $request->jangkauan_pemasaran : (array) $request->jangkauan_pemasaran
        ]);

        $rules = [
            'pelaku_usaha_id' => 'required|exists:tahap1,id',
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
            'instansi' => 'nullable|array',
            'instansi.*' => 'nullable|string|max:255',
            'legalitas_usaha' => 'nullable|string|max:255',
            'tahun_pendirian' => 'nullable|string|max:4',
            'foto_produk.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_tempat_produksi.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_usaha' => 'nullable|in:Pangan,Nonpangan',
            'sni_yang_akan_diterapkan' => 'nullable|string',
            'lspro' => 'nullable|string|max:255',
            'tanda_daftar_merek' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);

        $pelaku_usaha_id = $request->pelaku_usaha_id;
        $validated['instansi'] = json_encode($validated['instansi']);

        // Handle foto produk
        $foto_produk_paths = [];
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                if ($file->isValid()) {
                    $filename = uniqid() . '_produk.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('uploads/foto_produk', $filename, 'public');
                    $foto_produk_paths[] = $path;
                }
            }
        }

        if ($isEdit) {
            $existing = Tahap2::where('pelaku_usaha_id', $pelaku_usaha_id)->first();
            $existing_produk = $existing && $existing->foto_produk ? json_decode($existing->foto_produk, true) : [];
            $foto_produk_paths = array_merge($existing_produk, $foto_produk_paths);
        }
        $validated['foto_produk'] = json_encode($foto_produk_paths);

        // Handle foto tempat produksi
        $foto_tempat_paths = [];
        if ($request->hasFile('foto_tempat_produksi')) {
            foreach ($request->file('foto_tempat_produksi') as $file) {
                if ($file->isValid()) {
                    $filename = uniqid() . '_tempat.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('uploads/foto_tempat_produksi', $filename, 'public');
                    $foto_tempat_paths[] = $path;
                }
            }
        }

        if ($isEdit) {
            $existing = Tahap2::where('pelaku_usaha_id', $pelaku_usaha_id)->first();
            $existing_tempat = $existing && $existing->foto_tempat_produksi ? json_decode($existing->foto_tempat_produksi, true) : [];
            $foto_tempat_paths = array_merge($existing_tempat, $foto_tempat_paths);
        }
        $validated['foto_tempat_produksi'] = json_encode($foto_tempat_paths);

        $validated['jangkauan_pemasaran'] = json_encode($validated['jangkauan_pemasaran']);

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
