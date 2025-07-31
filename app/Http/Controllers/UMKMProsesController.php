<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
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

    public function store(Request $request, $tahap)
    {
        // ---------------- Tahap 1 ----------------
        if ($tahap == 1) {
            $validated = $request->validate([
                'nama_pelaku' => 'nullable|string|max:255',
                'produk' => 'nullable|string|max:255',
                'klasifikasi' => 'nullable|string',
                'status' => 'nullable|string',
                'pembina_1' => 'nullable|string',
                'pembina_2' => 'nullable|string',
                'sinergi' => 'nullable|string',
                'nama_kontak_person' => 'nullable|string',
                'no_hp' => 'nullable|string',
                'bulan_pertama_pembinaan' => 'nullable|string',
                'tahun_dibina' => 'nullable|string',
                'riwayat_pembinaan' => 'nullable|string',
                'status_pembinaan' => 'nullable|string',
                'email' => 'nullable|email',
                'media_sosial' => 'nullable|string',
                'nama_merek' => 'nullable|string',
                'tanda_daftar_merek' => 'nullable|string',
            ]);

            $tahap1 = Tahap1::create($validated);

            return redirect()->route('tahap.create.tahap', [
                'tahap' => 2,
                'id' => $tahap1->id
            ])->with('success', 'Tahap 1 disimpan');
        }

        // ---------------- Tahap 2 ----------------
        if ($tahap == 2) {
            $validated = $request->validate([
                'pelaku_usaha_id' => 'required|exists:pelaku_usaha,id',
                'omzet' => 'nullable|numeric',
                'volume_per_tahun' => 'nullable|numeric',
                'jumlah_tenaga_kerja' => 'nullable|numeric',
                'jangkauan_pemasaran' => 'nullable|array',
                'jangkauan_pemasaran.*' => 'in:Local,Nasional,Internasional',
                'link_dokumen' => 'nullable|url',
                'alamat_kantor' => 'nullable|string',
                'provinsi_kantor' => 'nullable|string',
                'kota_kantor' => 'nullable|string',
                'alamat_pabrik' => 'nullable|string',
                'provinsi_pabrik' => 'nullable|string',
                'kota_pabrik' => 'nullable|string',
                'legalitas_usaha' => 'nullable|string',
                'tahun_pendirian' => 'nullable|string',
                'foto_produk' => 'nullable|array',
                'foto_produk.*' => 'image|mimes:jpg,jpeg,png',
                'foto_tempat_produksi' => 'nullable|array',
                'foto_tempat_produksi.*' => 'image|mimes:jpg,jpeg,png',
                'jenis_usaha' => 'nullable|string',
                'sni_yang_akan_diterapkan' => 'nullable|string',
                'lspro' => 'nullable|string',
                'tanda_daftar_merek' => 'nullable|array',
                'instansi' => 'nullable|string',
                'sertifikat' => 'nullable|string',
            ]);

            $tahap2 = Tahap2::firstOrNew(['pelaku_usaha_id' => $validated['pelaku_usaha_id']]);

            // Foto Produk
            $validated['foto_produk'] = $request->file('foto_produk')
                ? array_map(fn($f) => $f->store('uploads/foto_produk', 'public'), $request->file('foto_produk'))
                : ($tahap2->foto_produk ?? []);

            // Foto Tempat Produksi
            $validated['foto_tempat_produksi'] = $request->file('foto_tempat_produksi')
                ? array_map(fn($f) => $f->store('uploads/foto_tempat', 'public'), $request->file('foto_tempat_produksi'))
                : ($tahap2->foto_tempat_produksi ?? []);

            // Array
            $validated['jangkauan_pemasaran'] = $validated['jangkauan_pemasaran'] ?? [];
            $validated['tanda_daftar_merek'] = $validated['tanda_daftar_merek'] ?? [];

            $tahap2->fill($validated)->save();

            return redirect()->route('umkm.sertifikasi.index')->with('success', 'UMKM berhasil disimpan');
        }

        abort(404, 'Tahap tidak valid.');
    }
}
