<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UMKMSertifikasiController extends Controller
{
    public function index(Request $request)
    {
        // $query = Tahap1::with('tahap2')
        //     ->where('status_pembinaan', 'SPPT SNI (Tersertifikasi)');

        // if ($request->has('search')) {
        //     $search = $request->search;
        //     $query->where('nama_pelaku', 'like', '%' . $search . '%');
        // }

        // $items = $query->latest()->paginate(10);

        $items= Tahap1::where('status_pembinaan','=','SPPT SNI')->get(); 

        return view('umkm.sertifikasi.index', compact('items'));
    }

    public function sertifikasi($id)
    {
        $umkm = Tahap1::with('tahap2')->findOrFail($id);

        $umkm->update([
            'status' => 'Tersertifikasi'
        ]);

        return redirect()->route('umkm.sertifikasi.index')->with('success', 'UMKM berhasil disertifikasi.');
    }

    public function edit($id)
    {
        $tahap1 = Tahap1::with('tahap2')->findOrFail($id);
        $tahap2 = $tahap1->tahap2;

        return view('umkm.sertifikasi.edit', compact('tahap1', 'tahap2'));
    }

    public function update(Request $request, int $id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        $validated = $request->validate([
            'nama_pelaku' => 'nullable|string|max:255',
            'produk' => 'nullable|string|max:255',
            'klasifikasi' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'pembina_1' => 'nullable|string|max:255',
            'pembina_2' => 'nullable|string|max:255',
            'sinergi' => 'nullable|string|max:255',
            'nama_kontak_person' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'bulan_pertama_pembinaan' => 'nullable|string',
            'tahun_dibina' => 'nullable|string',
            'riwayat_pembinaan' => 'nullable|string',
            'status_pembinaan' => 'nullable|string',
            'email' => 'nullable|email',
            'media_sosial' => 'nullable|string',
            'nama_merek' => 'nullable|string',
            'omzet' => 'nullable|numeric',
            'volume_per_tahun' => 'nullable|numeric',
            'jumlah_tenaga_kerja' => 'nullable|integer',
            'jangkauan_pemasaran' => 'nullable|array',
            'jangkauan_pemasaran.*' => 'string',
            'link_dokumen' => 'nullable|string',
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
            'sni_yang_diterapkan' => 'nullable|string',
            'lspro' => 'nullable|string',
            'tanda_daftar_merk' => 'nullable|string',
        ]);

        // Upload foto baru
        $foto_produk_paths = $tahap2?->foto_produk ?? [];
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                $foto_produk_paths[] = $file->store('uploads/foto_produk', 'public');
            }
        }

        $foto_tempat_paths = $tahap2?->foto_tempat_produksi ?? [];
        if ($request->hasFile('foto_tempat_produksi')) {
            foreach ($request->file('foto_tempat_produksi') as $file) {
                $foto_tempat_paths[] = $file->store('uploads/foto_tempat', 'public');
            }
        }

        // Update Tahap 1
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
            'jenis_usaha' => $request->jenis_usaha,
            'lspro' => $request->lspro,
            'tanda_daftar_merk' => $request->tanda_daftar_merk,
        ]);

        // Update Tahap 2
        if ($tahap2) {
            $tahap2->update([
                'omzet' => $request->omzet,
                'volume_per_tahun' => $request->volume_per_tahun,
                'jumlah_tenaga_kerja' => $request->jumlah_tenaga_kerja,
                'jangkauan_pemasaran' => $request->jangkauan_pemasaran ?? [],
                'link_dokumen' => $request->link_dokumen,
                'alamat_kantor' => $request->alamat_kantor,
                'provinsi_kantor' => $request->provinsi_kantor,
                'kota_kantor' => $request->kota_kantor,
                'alamat_pabrik' => $request->alamat_pabrik,
                'provinsi_pabrik' => $request->provinsi_pabrik,
                'kota_pabrik' => $request->kota_pabrik,
                'legalitas_usaha' => $request->legalitas_usaha,
                'tahun_pendirian' => $request->tahun_pendirian,
                'foto_produk' => $foto_produk_paths,
                'foto_tempat_produksi' => $foto_tempat_paths,
                'sni_yang_diterapkan' => $request->sni_yang_diterapkan,
            ]);
        }

        return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data sertifikasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tahap1 = Tahap1::findOrFail($id);

        DB::transaction(function () use ($tahap1) {
            $tahap1->update(['status' => '']);
        });

        return redirect()->back()->with('success', 'Status sertifikasi dibatalkan dan data dikembalikan ke proses.');
    }
}
