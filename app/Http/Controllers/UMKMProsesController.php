<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
use Illuminate\Support\Str;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;

class UMKMProsesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $tahap1 = Tahap1::where('status', '!=', 'Tersertifikasi')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_pelaku', 'like', "%$search%")
                      ->orWhere('produk', 'like', "%$search%");
            })
            ->get();

        return view('umkm.proses.index', compact('tahap1'));
    }

    public function destroy($id)
    {
        $umkm = Tahap1::with('tahap2')->findOrFail($id);

        if ($umkm->status === 'Tersertifikasi') {
            return redirect()->back()->with('error', 'Data UMKM sudah tersertifikasi dan tidak dapat dihapus.');
        }

        $umkm->tahap2()->delete();
        $umkm->delete();

        return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data proses berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first() ?? new Tahap2(['pelaku_usaha_id' => $id]);

        // 1️⃣ Update Tahap 1
        $tahap1->update($request->only([
            'nama_pelaku','produk','klasifikasi','status','pembina_1','pembina_2',
            'sinergi','nama_kontak_person','no_hp','bulan_pertama_pembinaan',
            'tahun_dibina','riwayat_pembinaan','status_pembinaan','email',
            'media_sosial','nama_merek'
        ]));

        // 2️⃣ Persiapkan data Tahap 2
        $data2 = $request->only([
            'omzet','volume_per_tahun','jumlah_tenaga_kerja','link_dokumen',
            'alamat_kantor','provinsi_kantor','kota_kantor',
            'alamat_pabrik','provinsi_pabrik','kota_pabrik',
            'legalitas_usaha','tahun_pendirian','jenis_usaha',
            'sni_yang_akan_diterapkan','lspro','instansi','sertifikat'
        ]);

        // Checkbox & Array
        $data2['jangkauan_pemasaran'] = $request->input('jangkauan_pemasaran', []);
        $data2['tanda_daftar_merek'] = $request->input('tanda_daftar_merek', []);

        // 3️⃣ Foto Produk
        $fotoProduk = $request->input('old_foto_produk', $tahap2->foto_produk ?? []);
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                $fotoProduk[] = $file->store('uploads/foto_produk', 'public');
            }
        }
        $data2['foto_produk'] = $fotoProduk;

        // 4️⃣ Foto Tempat Produksi
        $fotoTempat = $request->input('old_foto_tempat_produksi', $tahap2->foto_tempat_produksi ?? []);
        if ($request->hasFile('foto_tempat_produksi')) {
            foreach ($request->file('foto_tempat_produksi') as $file) {
                $fotoTempat[] = $file->store('uploads/foto_tempat', 'public');
            }
        }
        $data2['foto_tempat_produksi'] = $fotoTempat;

        // 5️⃣ Simpan Tahap 2
        $tahap2->fill($data2)->save();

        // 6️⃣ Simpan otomatis ke Sertifikasi jika SPPT SNI
        if ($tahap1->status_pembinaan === '9. SPPT SNI') {
            Sertifikasi::updateOrCreate(
                ['pelaku_usaha_id' => $tahap1->id],
                array_merge($tahap1->toArray(), $data2)
            );

            $tahap1->update(['status' => 'Tersertifikasi']);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
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
                'foto_produk' => 'nullable|array',
                'foto_produk.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'foto_tempat_produksi' => 'nullable|array',
                'foto_tempat_produksi.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'jenis_usaha' => 'nullable|in:Pangan,Nonpangan',
                'sni_yang_diterapkan' => 'nullable|string',
                'sertifikat' => 'nullable|string',
            ];

            $validated = $request->validate($rules);

            

            $pelaku_usaha_id = $request->pelaku_usaha_id;
            $validated['instansi'] = json_encode($validated['instansi']);

        // Proses upload foto_produk (walaupun tidak divalidasi)
            $foto_produk_paths = [];
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    if ($file && $file->isValid()) {
                        $filename = Str::random(10) . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('foto_produk', $filename, 'public');
                        $foto_produk_paths[] = $filename;
                    }
                }
            }

            // Proses upload foto_tempat_produksi
            $foto_tempat_produksi_paths = [];
            if ($request->hasFile('foto_tempat_produksi')) {
                foreach ($request->file('foto_tempat_produksi') as $file) {
                    if ($file && $file->isValid()) {
                        $filename = Str::random(10) . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('foto_tempat_produksi', $filename, 'public');
                        $foto_tempat_produksi_paths[] = $filename;
                    }
                }
            }

            $validated['foto_produk'] = json_encode($foto_produk_paths);
            $validated['foto_tempat_produksi'] = json_encode($foto_tempat_produksi_paths);

            if ($isEdit) {
                Tahap2::updateOrCreate(['pelaku_usaha_id' => $pelaku_usaha_id], $validated);
            } else {
                Tahap2::create($validated);
            }
            

            return redirect()->route('umkm.proses.index')->with('success', 'Tahap 2 berhasil disimpan');
        }
        
        abort(404, 'Tahap tidak valid.');
    }

    public function createTahap($tahap, $id = null)
    {
        return view('tahap.create', compact('tahap', 'id'));
    }
}
