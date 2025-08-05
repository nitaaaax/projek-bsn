<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Provinsi;
use App\Models\Kota;

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

    public function update(Request $request, $id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        /* -----------------------------
        1. Validasi Tahap 1
        ----------------------------- */
        $validated1 = $request->validate([
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
            'tanda_daftar_merk' => 'nullable|in:Terdaftar di Kemenkumham,Belum Terdaftar',
        ]);

        /* -----------------------------
        2. Validasi Tahap 2
        ----------------------------- */
        $validated2 = $request->validate([
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

        /* -----------------------------
        3. Update Tahap 1
        ----------------------------- */
        $tahap1->update($validated1);

            // 4. Upload Foto Produk & Tempat Produksi
        $foto_produk = $tahap2 && is_array($tahap2->foto_produk) ? $tahap2->foto_produk : [];
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $foto) {
                $foto_produk[] = $foto->store('public/uploads/foto_produk', 'public');
            }
        }
        $validated2['foto_produk'] = $foto_produk; // Tidak perlu json_encode()

        $foto_tempat = $tahap2 && is_array($tahap2->foto_tempat_produksi) ? $tahap2->foto_tempat_produksi : [];
        if ($request->hasFile('foto_tempat_produksi')) {
            foreach ($request->file('foto_tempat_produksi') as $foto) {
                $foto_tempat[] = $foto->store('public/uploads/foto_tempat_produksi', 'public');
            }
        }
        $validated2['foto_tempat_produksi'] = $foto_tempat; // Tidak perlu json_encode()


        /* -----------------------------
        5. Handle Field JSON
        ----------------------------- */
    $validated2['tanda_daftar_merk'] = $request->input('tanda_daftar_merk', $tahap2->tanda_daftar_merk ?? null);


        $validated2['jangkauan_pemasaran'] = $request->input('jangkauan_pemasaran', $tahap2->jangkauan_pemasaran ?? []);


        // Gabungkan instansi_check + instansi_detail
        $instansi = [];
        if ($request->filled('instansi_check')) {
            foreach ($request->input('instansi_check') as $key) {
                $instansi[$key] = $request->input("instansi_detail.$key");
            }
        }
    $validated2['instansi'] = !empty($instansi)
        ? $instansi
        : ($tahap2->instansi ?? []);

        /* -----------------------------
        6. Simpan / Update Tahap 2
        ----------------------------- */
        $validated2['pelaku_usaha_id'] = $id;
        $tahap2 = Tahap2::updateOrCreate(
            ['pelaku_usaha_id' => $id],
            $validated2
        );

        /* -----------------------------
        7. Simpan ke Sertifikasi (opsional)
        ----------------------------- */
        if (trim($tahap1->status_pembinaan) === '9.SPPT SNI') {
            Sertifikasi::updateOrCreate(
                ['pelaku_usaha_id' => $tahap1->id],
                [
                    'pelaku_usaha_id' => $tahap1->id,
                    'tahap1_id' => $tahap1->id,
                    'tahap2_id' => $tahap2->id ?? null,
                    'nama_pelaku' => $tahap1->nama_pelaku,
                    'produk' => $tahap1->produk,
                    'status' => 'Tersertifikasi',
                    'bulan_pertama_pembinaan' => $tahap1->bulan_pertama_pembinaan ?? 'Januari',
                    'data_tahap1' => json_encode($tahap1->getAttributes(), JSON_PARTIAL_OUTPUT_ON_ERROR),
                    'data_tahap2' => json_encode($validated2, JSON_PARTIAL_OUTPUT_ON_ERROR),
                ]
            );
        }

        return redirect()->route('umkm.proses.index')->with('success', 'Data UMKM berhasil diperbarui.');
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
            foreach ($tahap2->foto_produk ?? [] as $file) {
                $path = public_path("storage/" . $file);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // Hapus file foto_tempat_produksi
            foreach ($tahap2->foto_tempat_produksi ?? [] as $file) {
                $path = public_path("storage/" . $file);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $tahap2->delete();
        }

        $tahap1->delete();

        return redirect()->route('umkm.proses.index')->with('success', 'Data UMKM berhasil dihapus.');
    }

    public function showUser($id)
{
    $tahap1 = Tahap1::findOrFail($id);
    $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

    return view('user.showuser', compact('tahap1', 'tahap2'));
    }

    private function isTahap2Complete($tahap2)
    {
        return !empty($tahap2->omzet)
            && !empty($tahap2->volume_per_tahun)
            && !empty($tahap2->alamat_pabrik)
            && !empty($tahap2->foto_produk)
            && !empty($tahap2->foto_tempat_produksi);
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
