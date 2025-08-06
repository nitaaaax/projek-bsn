<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
use App\Models\Sertifikasi;
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
        // $search = $request->search;

        // $tahap1 = Tahap1::where('status_pembinaan', '!=', 'SPPT SNI (Tersertifikasi)')
        //         ->when($search, function ($query) use ($search) {
        //         $query->where(function ($q) use ($search) {
        //             $q->where('nama_pelaku', 'like', "%$search%")
        //             ->orWhere('produk', 'like', "%$search%");
        //         });
        //     })
        //     ->latest()
        //     ->paginate(10);

        $tahap1= Tahap1::where('status_pembinaan','!=','SPPT SNI')->get(); 

        return view('umkm.proses.index', compact('tahap1'));
    }


    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            // Ambil data tahap 1
            $tahap1 = Tahap1::findOrFail($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

            // === Validasi Tahap 1 ===
            $validated1 = $request->validate([
                'nama_pelaku' => 'nullable|string|max:255',
                'produk' => 'nullable|string|max:255',
                'klasifikasi' => 'nullable|string|max:255',
                'pembina_1' => 'nullable|string|max:255',
                'pembina_2' => 'nullable|string|max:255',
                'status_pembinaan' => 'nullable|string|max:50',
                'sinergi' => 'nullable|string|max:255',
                'nama_kontak_person' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string|max:25',
                'email' => 'nullable|email|max:255',
                'media_sosial' => 'nullable|string|max:255',
            ]);

            $tahap1->update($validated1);

            // === Validasi Tahap 2 ===
            $validated2 = $request->validate([
                'nama_merek' => 'nullable|string|max:255',
                'omzet' => 'nullable|numeric',
                'alamat_kantor' => 'nullable|string|max:255',
                'alamat_pabrik' => 'nullable|string|max:255',
                'jangkauan_pemasaran' => 'nullable|array',
                'jangkauan_pemasaran.*' => 'string',
                'foto_produk.*' => 'nullable|image|max:2048',
                'foto_tempat_produksi.*' => 'nullable|image|max:2048',
            ]);

            // Jangkauan
            $validated2['jangkauan_pemasaran'] = json_encode($validated2['jangkauan_pemasaran'] ?? []);

            // Foto produk
            $fotoProduk = json_decode($tahap2->foto_produk ?? '[]', true);
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    $fotoProduk[] = $file->store('uploads/foto_produk', 'public');
                }
            }

            // Foto tempat produksi
            $fotoTempat = json_decode($tahap2->foto_tempat_produksi ?? '[]', true);
            if ($request->hasFile('foto_tempat_produksi')) {
                foreach ($request->file('foto_tempat_produksi') as $file) {
                    $fotoTempat[] = $file->store('uploads/foto_tempat', 'public');
                }
            }

            $validated2['foto_produk'] = json_encode($fotoProduk);
            $validated2['foto_tempat_produksi'] = json_encode($fotoTempat);
            $validated2['instansi'] = json_encode($request->input('instansi_check') ?? []);


            $tahap2->update($validated2);
        });

        return redirect()->route('umkm.proses.index')->with('success', 'Data UMKM berhasil diperbarui.');
    }



    protected function updateProses(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            // Ambil atau fail
            $tahap1 = Tahap1::findOrFail($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

            // 1. Validasi Tahap1 (sesuaikan jika perlu)
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

            // 2. Validasi Tahap2 (sederhana, bisa diperluas)
            $validated2 = $request->validate([
                'omzet' => 'nullable|numeric',
                'alamat_pabrik' => 'nullable|string|max:255',
                'alamat_kantor' => 'nullable|string|max:255',
                'provinsi_kantor' => 'nullable|string|max:255',
                'kota_kantor' => 'nullable|string|max:255',
                'provinsi_pabrik' => 'nullable|string|max:255',
                'kota_pabrik' => 'nullable|string|max:255',
                'jangkauan_pemasaran' => 'nullable|array',
                'jangkauan_pemasaran.*' => 'in:Local,Nasional,Internasional',
                'instansi_check' => 'nullable|array',
                'instansi_check.*' => 'string|in:Dinas,Kementerian,Perguruan Tinggi,Komunitas',
                'instansi_detail' => 'nullable|array',
                'instansi_detail.*' => 'nullable|string|max:255',
                'foto_produk.*' => 'nullable|image|max:2048',
                'foto_tempat_produksi.*' => 'nullable|image|max:2048',
                'sni_yang_diterapkan' => 'nullable|string',
                'sertifikat' => 'nullable|string',
                'gruping' => 'nullable|string',
            ]);

            // 3. Update Tahap1
            $tahap1->update($validated1);

            // 4. Merge gambar lama + baru untuk Tahap2
            $fotoProdukLama = $tahap2 && $tahap2->foto_produk ? json_decode($tahap2->foto_produk, true) : [];
            $fotoTempatLama = $tahap2 && $tahap2->foto_tempat_produksi ? json_decode($tahap2->foto_tempat_produksi, true) : [];

            $mergedFotoProduk = $this->mergeOldWithNewFiles($request, $fotoProdukLama, 'foto_produk');
            $mergedFotoTempat = $this->mergeOldWithNewFiles($request, $fotoTempatLama, 'foto_tempat_produksi');

            // 5. Gabungkan instansi
            $instansiCheck = $request->input('instansi_check', []);
            $instansiDetail = $request->input('instansi_detail', []);
            $instansiGabungan = [];
            foreach ($instansiCheck as $item) {
                $instansiGabungan[$item] = $instansiDetail[$item] ?? '';
            }

            // 6. Siapkan data untuk Tahap2
            $tahap2Data = [
                'omzet' => $validated2['omzet'] ?? null,
                'alamat_kantor' => $validated2['alamat_kantor'] ?? null,
                'provinsi_kantor' => $validated2['provinsi_kantor'] ?? null,
                'kota_kantor' => $validated2['kota_kantor'] ?? null,
                'alamat_pabrik' => $validated2['alamat_pabrik'] ?? null,
                'provinsi_pabrik' => $validated2['provinsi_pabrik'] ?? null,
                'kota_pabrik' => $validated2['kota_pabrik'] ?? null,
                'jangkauan_pemasaran' => $request->input('jangkauan_pemasaran', $tahap2->jangkauan_pemasaran ?? []),
                'instansi' => json_encode($instansiGabungan),
                'foto_produk' => json_encode($mergedFotoProduk),
                'foto_tempat_produksi' => json_encode($mergedFotoTempat),
                'sni_yang_diterapkan' => $validated2['sni_yang_diterapkan'] ?? null,
                'sertifikat' => $validated2['sertifikat'] ?? null,
                'gruping' => $validated2['gruping'] ?? null,
                'pelaku_usaha_id' => $id,
            ];

            // 7. Simpan Tahap2
            $tahap2 = Tahap2::updateOrCreate(['pelaku_usaha_id' => $id], $tahap2Data);

            // 8. Jika status pembinaan SPPT SNI → buat / update sertifikasi
            if (trim($validated1['status_pembinaan'] ?? '') === 'SPPT SNI') {
                $foto_produk = json_decode($tahap2->foto_produk ?? '[]', true);
                $foto_tempat_produksi = json_decode($tahap2->foto_tempat_produksi ?? '[]', true);

                $payloadSertifikasi = [
                    // Data Tahap 1
                    'pelaku_usaha_id' => $tahap1->id,
                    'tahap1_id' => $tahap1->id,
                    'tahap2_id' => $tahap2->id,
                    'nama_pelaku' => $request->nama_pelaku,
                    'produk' => $request->produk,
                    'klasifikasi' => $request->klasifikasi,
                    'pembina_1' => $request->pembina_1,
                    'pembina_2' => $request->pembina_2,
                    'status_pembinaan' => $request->status_pembinaan,
                    'bulan_pertama_pembinaan' => $request->bulan_pertama_pembinaan ?? 'Januari',
                    'tahun_dibina' => $request->tahun_dibina,
                    'riwayat_pembinaan' => $request->riwayat_pembinaan,
                    'tanda_daftar_merk' => $request->tanda_daftar_merk,

                    // Data Tahap 2
                    'alamat_kantor' => $request->alamat_kantor,
                    'alamat_pabrik' => $request->alamat_pabrik,
                    'no_telp' => $request->no_telp,
                    'website' => $request->website,
                    'email' => $request->email,
                    'instagram' => $request->instagram,
                    'facebook' => $request->facebook,
                    'omzet' => $request->omzet,
                    'kapasitas_produksi' => $request->kapasitas_produksi,
                    'jangkauan_pemasaran' => json_encode($request->jangkauan_pemasaran ?? []),
                    'foto_produk' => json_encode($foto_produk),
                    'foto_tempat_produksi' => json_encode($foto_tempat_produksi),
                    'sni_yang_diterapkan' => $request->sni_yang_diterapkan,
                    'gruping' => $request->gruping,

                    // Status sertifikasi
                    'status' => 'Tersertifikasi',

                    // Backup data mentah
                    'data_tahap1' => json_encode($tahap1->getAttributes(), JSON_PARTIAL_OUTPUT_ON_ERROR),
                    'data_tahap2' => json_encode($tahap2->getAttributes(), JSON_PARTIAL_OUTPUT_ON_ERROR),
                ];

                // Cek apakah sudah ada data sertifikasi sebelumnya
                $sertifikasi = Sertifikasi::where('pelaku_usaha_id', $tahap1->id)->first();
                if ($sertifikasi) {
                    $sertifikasi->update($payloadSertifikasi);
                } else {
                    Sertifikasi::create($payloadSertifikasi);
                }
            }


        });

        // tidak redirect di sini karena pemanggilnya yang handle
    }

    public function show($id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        $jangkauan = ['Lokal', 'Regional', 'Nasional', 'Internasional'];

        return view('umkm.show', compact('tahap1', 'tahap2', 'jangkauan'));
    }
    public function edit($id)
    {
        // Ambil data Tahap 1 dan Tahap 2 berdasarkan ID pelaku usaha
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        // Ambil data instansi dari Tahap 2 (bisa array atau JSON)
        $instansiArray = [];
        if ($tahap2 && $tahap2->instansi) {
            $instansiArray = is_array($tahap2->instansi)
                ? $tahap2->instansi
                : json_decode($tahap2->instansi, true);
        }

        // Jika ada data gambar juga (opsional)
        $foto_produk = $tahap2 && $tahap2->foto_produk
            ? json_decode($tahap2->foto_produk, true)
            : [];

        $foto_tempat_produksi = $tahap2 && $tahap2->foto_tempat_produksi
            ? json_decode($tahap2->foto_tempat_produksi, true)
            : [];

        // Kirim data ke view edit
        return view('admin.umkm.tahap.form', compact(
            'tahap1',
            'tahap2',
            'instansiArray',
            'foto_produk',
            'foto_tempat_produksi'
        ));
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

    public function showUser($id){
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
