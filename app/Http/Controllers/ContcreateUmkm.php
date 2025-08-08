<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
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

        //dd($request->all());

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

            // Redirect ke tahap 2
            return redirect()->route('admin.umkm.create.tahap', [
                'tahap' => 2,
                'id' => $tahap1->id,
            ])->with('success', 'Data Tahap 1 berhasil disimpan. Lanjut ke Tahap 2.');
        }

        // === Tahap 2 ===
        if ($tahap === 2) {
            $tahap1 = Tahap1::find($id);
            if (!$tahap1) {
                abort(404, 'ID Tahap1 tidak ditemukan.');
            }

            $validated = $request->validate([
                'omzet' => 'nullable|numeric',
                'volume_per_tahun' => 'nullable|string|max:255',
                'jumlah_tenaga_kerja' => 'nullable|integer',
                'jangkauan_pemasaran' => 'nullable|array',

                'link_dokumen' => 'nullable|url|max:255',
                'alamat_kantor' => 'nullable|string|max:255',
                'provinsi_kantor' => 'nullable|string|max:255',
                'kota_kantor' => 'nullable|string|max:255',

                'alamat_pabrik' => 'nullable|string|max:255',
                'provinsi_pabrik' => 'nullable|string|max:255',
                'kota_pabrik' => 'nullable|string|max:255',

                'instansi_check' => 'nullable|array',
                'instansi_check.*' => 'string|in:Dinas,Kementerian,Perguruan Tinggi,Komunitas,Lainnya',
                'instansi_detail' => 'nullable|array',
                'instansi_detail.*' => 'nullable|string|max:255',

                'legalitas_usaha' => 'nullable|array',
                'legalitas_usaha.*' => 'nullable|string|max:255',
                'legalitas_usaha_lainnya' => 'nullable|string|max:255',

                'tahun_pendirian' => 'nullable|string|max:4',

                'foto_produk' => 'nullable|array',
                'foto_produk.*' => 'nullable|image',

                'foto_tempat_produksi' => 'nullable|array',
                'foto_tempat_produksi.*' => 'nullable|image',

                'sni_yang_diterapkan' => 'nullable|string',
                'sertifikat' => 'nullable|array',
                'sertifikat.*' => 'nullable|string|max:255',

                'gruping' => 'nullable|string',

                'jangkauan_detail' => 'nullable|array',
                'jangkauan_detail.*' => 'nullable|string|max:255',
                'jangkauan_pemasaran_lainnya' => 'nullable|string|max:255',
            ]);

            // === Handle legalitas_usaha (checkbox + optional "lainnya")
            $legalitas = $request->input('legalitas_usaha', []);
            // Add "lainnya" value if provided
            if ($request->filled('legalitas_usaha_lainnya')) {
                $legalitas[] = $request->legalitas_usaha_lainnya;
            }
            $validated['legalitas_usaha'] = json_encode(array_filter($legalitas));

            $sertifikat = $request->input('sertifikat', []);
            $validated['sertifikat'] = json_encode(array_filter($sertifikat));

            // Normalisasi jangkauan_pemasaran menjadi array numerik
            $jangkauanData = [];

            $jangkauanPemasaran = $request->jangkauan_pemasaran ?? [];
            $jangkauanDetail = $request->jangkauan_detail ?? [];
            $jangkauanLainnya = $request->jangkauan_pemasaran_lainnya;

            $finalJangkauan = [];

            foreach ($jangkauanPemasaran as $key => $value) {
                $finalJangkauan[$key] = $jangkauanDetail[$key] ?? '';
            }

            if (!empty($jangkauanLainnya)) {
                $lainnyaList = array_map('trim', explode(',', $jangkauanLainnya));
                foreach ($lainnyaList as $custom) {
                    if (!empty($custom)) {
                        $finalJangkauan[$custom] = $custom;
                    }
                }
            }

            $validated['jangkauan_pemasaran'] = json_encode($finalJangkauan);

            // === Handle instansi (checkbox + detail)
            $instansi = [];
            if ($request->filled('instansi_check')) {
                foreach ($request->input('instansi_check') as $key) {
                    $instansi[$key] = $request->input("instansi_detail.$key");
                }
            }
            $validated['instansi'] = json_encode($instansi);

            // === Upload foto produk
            $foto_produk_paths = [];
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    if ($file->isValid()) {
                        $filename = 'produk_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('public/uploads/foto_produk/', $filename);
                        $foto_produk_paths[] = str_replace('public/', '', $path);
                    }
                }
            }

            // === Upload foto tempat produksi
            $foto_tempat_produksi_paths = [];
            if ($request->hasFile('foto_tempat_produksi')) {
                foreach ($request->file('foto_tempat_produksi') as $file) {
                    if ($file->isValid()) {
                        $filename = 'tempat_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('public/uploads/foto_tempat_produksi', $filename);
                        $foto_tempat_produksi_paths[] = str_replace('public/', '', $path);
                    }
                }
            }

            $validated['foto_produk'] = json_encode($foto_produk_paths);
            $validated['foto_tempat_produksi'] = json_encode($foto_tempat_produksi_paths);
            $validated['pelaku_usaha_id'] = $id;

            // Simpan tahap 2
            $tahap2 = Tahap2::create($validated);

            return redirect()->route('umkm.proses.index')->with('success', 'Data berhasil disimpan.');
        }
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