<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Tahap1;
use App\Models\Tahap2;
use App\Models\Sertifikasi;

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

        $foto_produk = [];
        $foto_tempat_produksi = [];
        $data = null;

        if ($tahap === 1) {
            $data = Tahap1::find($id);
        } elseif ($tahap === 2) {
            $tahap1 = Tahap1::find($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

            if ($tahap2) {
                // Jika sudah ada Tahap 2
                $data = $tahap2;
                $foto_produk = json_decode($tahap2->foto_produk ?? '[]', true);
                $foto_tempat_produksi = json_decode($tahap2->foto_tempat_produksi ?? '[]', true);
            } else {
                // Kalau belum ada Tahap 2, buat data default dari Tahap 1
                $data = new \stdClass();
                $data->alamat_kantor = $tahap1->alamat_kantor ?? '';
                $data->provinsi_kantor = $tahap1->provinsi ?? '';
                $data->kota_kantor = $tahap1->kota ?? '';
                $data->alamat_pabrik = $tahap1->alamat_pabrik ?? '';
                $data->provinsi_pabrik = $tahap1->provinsi ?? '';
                $data->kota_pabrik = $tahap1->kota ?? '';
                $data->legalitas_usaha = $tahap1->legalitas ?? '';
                $data->tahun_pendirian = $tahap1->tahun_dibina ?? '';
                $data->omzet = '';
                $data->volume_per_tahun = '';
                $data->jumlah_tenaga_kerja = '';
                $data->jangkauan_pemasaran = json_encode([]);
                $data->link_dokumen = '';
                $data->instansi = json_encode([]);
                $data->sertifikat = '';
                $data->sni_yang_diterapkan = '';
                $data->gruping = '';
            }
        }

        return view('tahap.create', [
            'tahapNumber' => $tahap,
            'tahap' => $tahap,
            'data' => $data,
            'id' => $id,
            'pelaku_usaha_id' => $id,
            'foto_produk' => $foto_produk,
            'foto_tempat_produksi' => $foto_tempat_produksi,
        ]);
    }

    public function store(Request $request, int $tahap, $id = null)
    {
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
                'tanda_daftar_merk' => 'nullable|in:Terdaftar di Kemenkumham,Belum Terdaftar',
            ]);

            $tahap1 = Tahap1::create($validated);
            
                // redirect ke tahap 2
                return redirect()->route('admin.umkm.create.tahap', [
                    'tahap' => 2,
                    'id' => $tahap1->id,
                ])->with('success', 'Data Tahap 1 berhasil disimpan. Lanjut ke Tahap 2.');
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

            if ($request->status_pembinaan === 'SPPT SNI (Tersertifikasi)') {
            // Upload foto produk
            $foto_produk = [];
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    $foto_produk[] = $file->store('uploads/foto_produk', 'public');
                }
            }

            // Upload foto tempat produksi
            $foto_tempat_produksi = [];
            if ($request->hasFile('foto_tempat_produksi')) {
                foreach ($request->file('foto_tempat_produksi') as $file) {
                    $foto_tempat_produksi[] = $file->store('uploads/foto_tempat_produksi', 'public');
                }
            }

            // Simpan langsung ke sertifikasi
            $sertifikasi = Sertifikasi::create([
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

                // Tambahan data dari tahap 2
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
                'status' => 'Tersertifikasi',
            ]);

            return redirect()->route('admin.sertifikasi.index')->with('success', 'Data langsung masuk ke sertifikasi!');
        }
            // Upload foto
            $foto_produk_paths = [];
            $foto_tempat_produksi_paths = [];

            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    if ($file->isValid()) {
                        $filename = 'produk_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('public/uploads/foto_produk/', $filename);
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

            $tahap2 = Tahap2::create($validated);
            $tahap1 = Tahap1::findOrFail($id);

            // ===== Auto Masuk ke Sertifikasi jika SPPT SNI =====
            if (Str::contains($tahap1->status_pembinaan, 'SPPT SNI')) {
                Sertifikasi::updateOrCreate(
                ['pelaku_usaha_id' => $tahap1->id],
                [
                'pelaku_usaha_id' => $tahap1->id,
                'tahap1_id' => $tahap1->id,
                'tahap2_id' => $tahap2->id,

                // Dari Tahap 1
                'nama_pelaku' => $tahap1->nama_pelaku,
                'produk' => $tahap1->produk,
                'klasifikasi' => $tahap1->klasifikasi,
                'pembina_1' => $tahap1->pembina_1,
                'pembina_2' => $tahap1->pembina_2,
                'status_pembinaan' => $tahap1->status_pembinaan,
                'sinergi' => $tahap1->sinergi,
                'nama_kontak_person' => $tahap1->nama_kontak_person,
                'no_hp' => $tahap1->no_hp,
                'bulan_pertama_pembinaan' => $tahap1->bulan_pertama_pembinaan,
                'tahun_dibina' => $tahap1->tahun_dibina,
                'riwayat_pembinaan' => $tahap1->riwayat_pembinaan,
                'email' => $tahap1->email,
                'media_sosial' => $tahap1->media_sosial,
                'nama_merek' => $tahap1->nama_merek,
                'lspro' => $tahap1->lspro,
                'jenis_usaha' => $tahap1->jenis_usaha,
                'tanda_daftar_merk' => $tahap1->tanda_daftar_merk,

                // Dari Tahap 2
                'alamat_kantor' => $tahap2->alamat_kantor,
                'provinsi_kantor' => $tahap2->provinsi_kantor,
                'kota_kantor' => $tahap2->kota_kantor,
                'alamat_pabrik' => $tahap2->alamat_pabrik,
                'provinsi_pabrik' => $tahap2->provinsi_pabrik,
                'kota_pabrik' => $tahap2->kota_pabrik,
                'legalitas_usaha' => $tahap2->legalitas_usaha,
                'tahun_pendirian' => $tahap2->tahun_pendirian,
                'omzet' => $tahap2->omzet,
                'volume_per_tahun' => $tahap2->volume_per_tahun,
                'jumlah_tenaga_kerja' => $tahap2->jumlah_tenaga_kerja,
                'jangkauan_pemasaran' => $tahap2->jangkauan_pemasaran,
                'link_dokumen' => $tahap2->link_dokumen,
                'foto_produk' => $tahap2->foto_produk,
                'foto_tempat_produksi' => $tahap2->foto_tempat_produksi,
                'instansi' => $tahap2->instansi,
                'sertifikat' => $tahap2->sertifikat,
                'sni_yang_diterapkan' => $tahap2->sni_yang_diterapkan,
                'gruping' => $tahap2->gruping,

                // Tambahan
                'status' => 'Tersertifikasi',
                'data_tahap1' => json_encode($tahap1->getAttributes(), JSON_PARTIAL_OUTPUT_ON_ERROR),
                'data_tahap2' => json_encode($tahap2->getAttributes(), JSON_PARTIAL_OUTPUT_ON_ERROR),
            ]
        );

        // Update status pembinaan tahap1 jadi SPPT SNI
        $tahap1->update([
            'status_pembinaan' => 'SPPT SNI'
        ]);
    }
        }
            return redirect()->route('umkm.proses.index')->with('success', 'Data berhasil disimpan.');
    }
         
    protected function handleUpload(Request $request, $key)
    {
        $files = [];
        if ($request->hasFile($key)) {
            foreach ($request->file($key) as $file) {
                $files[] = $file->store("uploads/{$key}", 'public');
            }
        }
        return $files;
    }

}