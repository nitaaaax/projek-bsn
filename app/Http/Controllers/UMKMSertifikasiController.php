<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UMKMSertifikasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = Sertifikasi::all();

        return view('umkm.sertifikasi.index', [
            'role' => $user->role->name ?? 'user',
            'user' => $user,
            'data' => $data
        ]);
    }


    public function sertifikasi($id)
    {
        $umkm = Tahap1::with('tahap2')->findOrFail($id);

        $umkm->update(['status' => 'Tersertifikasi']);

        Sertifikasi::updateOrCreate(
            ['pelaku_usaha_id' => $umkm->id],
            [
                'nama_pelaku' => $umkm->nama_pelaku,
                'produk' => $umkm->produk,
                'klasifikasi' => $umkm->klasifikasi,
                'status' => 'Tersertifikasi',
                'kontak' => optional($umkm->tahap2)->no_hp,
                'alamat' => optional($umkm->tahap2)->alamat_kantor,
                'status_pembinaan' => $umkm->status_pembinaan,
                'email' => $umkm->email,
                'media_sosial' => $umkm->media_sosial,
                'jenis_usaha' => $umkm->jenis_usaha,
                'nama_merek' => $umkm->nama_merek,
                'tanda_daftar_merek' => $umkm->tanda_daftar_merek,
                'omzet' => optional($umkm->tahap2)->omzet,
                'volume_per_tahun' => optional($umkm->tahap2)->volume_per_tahun,
                'jumlah_tenaga_kerja' => optional($umkm->tahap2)->jumlah_tenaga_kerja,
                'jangkauan_pemasaran' => optional($umkm->tahap2)->jangkauan_pemasaran,
                'link_dokumen' => optional($umkm->tahap2)->link_dokumen,
                'foto_produk' => optional($umkm->tahap2)->foto_produk,
                'foto_tempat_produksi' => optional($umkm->tahap2)->foto_tempat_produksi,
            ]
        );

        return redirect()->route('umkm.sertifikasi.index')->with('success', 'UMKM berhasil disertifikasi dan dipindah ke tabel sertifikasi.');
    }

    public function edit($id)
    {
        $tahap1 = Tahap1::findOrFail($id); // ini benar
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();        
        $umkm   = Sertifikasi::where('pelaku_usaha_id', $id)->first();

        return view('umkm.sertifikasi.edit', compact('umkm', 'tahap1', 'tahap2'));
    }


    public function destroy($id)
    {
        $umkm = Sertifikasi::findOrFail($id);
        $umkm->delete();

        return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data UMKM berhasil dihapus.');
    }

    public function update(Request $request, int $id)
    {
        // === VALIDASI ===
        $request->validate([
            // TAHAP 1
            'nama_pelaku' => 'nullable|string|max:255',
            'produk' => 'nullable|string|max:255',
            'klasifikasi' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'pembina_1' => 'nullable|string|max:255',
            'pembina_2' => 'nullable|string|max:255',
            'sinergi' => 'nullable|string|max:255',
            'nama_kontak_person' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'bulan_pertama_pembinaan' => 'nullable|integer',
            'tahun_dibina' => 'nullable|string',
            'riwayat_pembinaan' => 'nullable|string',
            'status_pembinaan' => 'nullable|string',
            'email' => 'nullable|email',
            'media_sosial' => 'nullable|string',
            'nama_merek' => 'nullable|string',

            // TAHAP 2
            'omzet' => 'nullable|numeric',
            'volume_per_tahun' => 'nullable|numeric',
            'jumlah_tenaga_kerja' => 'nullable|integer',
            'jangkauan_pemasaran' => 'nullable|array',
            'jangkauan_pemasaran.*' => 'string',
            'link_dokumen' => 'nullable|url',
            'alamat_kantor' => 'nullable|string',
            'provinsi_kantor' => 'nullable|string',
            'kota_kantor' => 'nullable|string',
            'alamat_pabrik' => 'nullable|string',
            'provinsi_pabrik' => 'nullable|string',
            'kota_pabrik' => 'nullable|string',
            'legalitas_usaha' => 'nullable|string',
            'tahun_pendirian' => 'nullable|integer',
            'foto_produk.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_tempat_produksi.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_usaha' => 'nullable|string',
            'sni_yang_akan_diterapkan' => 'nullable|string',
            'lspro' => 'nullable|string',
            'tanda_daftar_merek' => 'nullable|string',
        ]);

        // === AMBIL DATA ===
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        // === UPDATE TAHAP 1 ===
        $tahap1->update([
            'nama_pelaku' => $request->nama_pelaku,
            'produk' => $request->produk,
            'klasifikasi' => $request->klasifikasi,
            'status' => $request->status,
            'pembina_1' => $request->pembina_1,
            'pembina_2' => $request->pembina_2,
            'sinergi' => $request->sinergi,
            'nama_kontak_person' => $request->nama_kontak_person,
            'no_hp' => $request->no_hp,
            'bulan_pertama_pembinaan' => $request->bulan_pertama_pembinaan,
            'tahun_dibina' => $request->tahun_dibina,
            'riwayat_pembinaan' => $request->riwayat_pembinaan,
            'status_pembinaan' => $request->status_pembinaan,
            'email' => $request->email,
            'media_sosial' => $request->media_sosial,
            'nama_merek' => $request->nama_merek,
        ]);

        // === UPDATE TAHAP 2 ===
        if ($tahap2) {
            // Jangkauan pemasaran
            $jangkauan = $request->jangkauan_pemasaran ? json_encode($request->jangkauan_pemasaran) : null;

            // Upload gambar produk
            $foto_produk_paths = [];
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    $foto_produk_paths[] = $file->store('uploads/foto_produk', 'public');
                }
            }

            // Upload gambar tempat produksi
            $foto_tempat_paths = [];
            if ($request->hasFile('foto_tempat_produksi')) {
                foreach ($request->file('foto_tempat_produksi') as $file) {
                    $foto_tempat_paths[] = $file->store('uploads/foto_tempat', 'public');
                }
            }

            $tahap2->update([
                'omzet' => $request->omzet,
                'volume_per_tahun' => $request->volume_per_tahun,
                'jumlah_tenaga_kerja' => $request->jumlah_tenaga_kerja,
                'jangkauan_pemasaran' => $jangkauan,
                'link_dokumen' => $request->link_dokumen,
                'alamat_kantor' => $request->alamat_kantor,
                'provinsi_kantor' => $request->provinsi_kantor,
                'kota_kantor' => $request->kota_kantor,
                'alamat_pabrik' => $request->alamat_pabrik,
                'provinsi_pabrik' => $request->provinsi_pabrik,
                'kota_pabrik' => $request->kota_pabrik,
                'legalitas_usaha' => $request->legalitas_usaha,
                'tahun_pendirian' => $request->tahun_pendirian,
                'foto_produk' => !empty($foto_produk_paths) ? json_encode($foto_produk_paths) : $tahap2->foto_produk,
                'foto_tempat_produksi' => !empty($foto_tempat_paths) ? json_encode($foto_tempat_paths) : $tahap2->foto_tempat_produksi,
                'jenis_usaha' => $request->jenis_usaha,
                'sni_yang_akan_diterapkan' => $request->sni_yang_akan_diterapkan,
                'lspro' => $request->lspro,
                'tanda_daftar_merek' => $request->tanda_daftar_merek,
            ]);
        }

        return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data proses berhasil diperbarui.');
    }


}
