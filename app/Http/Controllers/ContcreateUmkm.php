<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
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

    public function show($id = null)
    {
        $tahap1 = null;
        $tahap2 = null;
        $foto_produk = [];
        $foto_tempat_produksi = [];

        if ($id) {
            // Ambil data Tahap1 & Tahap2
            $tahap1 = Tahap1::find($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

            if ($tahap2) {
                $foto_produk = json_decode($tahap2->foto_produk ?? '[]', true);
                $foto_tempat_produksi = json_decode($tahap2->foto_tempat_produksi ?? '[]', true);
            } else {
                // Default Tahap 2 dari Tahap 1
                $tahap2 = new \stdClass();
                $tahap2->alamat_kantor = $tahap1->alamat_kantor ?? '';
                $tahap2->provinsi_kantor = $tahap1->provinsi ?? '';
                $tahap2->kota_kantor = $tahap1->kota ?? '';
                $tahap2->alamat_pabrik = $tahap1->alamat_pabrik ?? '';
                $tahap2->provinsi_pabrik = $tahap1->provinsi ?? '';
                $tahap2->kota_pabrik = $tahap1->kota ?? '';
                $tahap2->legalitas_usaha = $tahap1->legalitas ?? '';
                $tahap2->tahun_pendirian = $tahap1->tahun_dibina ?? '';
                $tahap2->omzet = '';
                $tahap2->volume_per_tahun = '';
                $tahap2->jumlah_tenaga_kerja = '';
                $tahap2->jangkauan_pemasaran = json_encode([]);
                $tahap2->link_dokumen = '';
                $tahap2->instansi = json_encode([]);
                $tahap2->sertifikat = '';
                $tahap2->sni_yang_diterapkan = '';
                $tahap2->gruping = '';
            }
        }

       return view('tahap.create', [
            'tahap1' => $tahap1,
            'tahap2' => $tahap2,
            'foto_produk' => $foto_produk,
            'foto_tempat_produksi' => $foto_tempat_produksi,
            'pelaku_usaha_id' => $id,
        ]);
    }

    public function store(Request $request)
    {
        // Validate all data at once
        $validated = $request->validate([
            // === Tahap 1 Fields ===
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
            
            // === Tahap 2 Fields ===
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
            'foto_produk.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'foto_tempat_produksi' => 'nullable|array',
            'foto_tempat_produksi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'sni_yang_diterapkan' => 'nullable|string',
            'sertifikat' => 'nullable|array',
            'sertifikat.*' => 'nullable|string|max:255',
            'gruping' => 'nullable|string',
            'jangkauan_detail' => 'nullable|array',
            'jangkauan_detail.*' => 'nullable|string|max:255',
            'jangkauan_pemasaran_lainnya' => 'nullable|string|max:255',
        ]);

        // Start database transaction
        DB::beginTransaction();

        try {
            // Separate data for each table
            $tahap1Data = Arr::only($validated, [
                'nama_pelaku', 'produk', 'klasifikasi', 'status', 'pembina_1', 'pembina_2', 
                'sinergi', 'nama_kontak_person', 'no_hp', 'bulan_pertama_pembinaan', 
                'tahun_dibina', 'riwayat_pembinaan', 'status_pembinaan', 'email', 
                'media_sosial', 'nama_merek', 'lspro', 'jenis_usaha', 'tanda_daftar_merk'
            ]);

            // Create Tahap1 record
            $tahap1 = Tahap1::create($tahap1Data);

            // Prepare Tahap2 data
            $tahap2Data = Arr::only($validated, [
                'omzet', 'volume_per_tahun', 'jumlah_tenaga_kerja', 'link_dokumen',
                'alamat_kantor', 'provinsi_kantor', 'kota_kantor', 'alamat_pabrik',
                'provinsi_pabrik', 'kota_pabrik', 'tahun_pendirian', 'sni_yang_diterapkan',
                'gruping'
            ]);

            // Handle special fields
            $tahap2Data['pelaku_usaha_id'] = $tahap1->id;

            // Handle legalitas_usaha (checkbox + optional "lainnya")
            $legalitas = $request->input('legalitas_usaha', []);
            if ($request->filled('legalitas_usaha_lainnya')) {
                $legalitas[] = $request->legalitas_usaha_lainnya;
            }
            $tahap2Data['legalitas_usaha'] = json_encode(array_filter($legalitas));

            // Handle sertifikat
            $tahap2Data['sertifikat'] = json_encode(array_filter($request->input('sertifikat', [])));

            // Handle jangkauan_pemasaran
            $finalJangkauan = [];
            $jangkauanPemasaran = $request->jangkauan_pemasaran ?? [];
            $jangkauanDetail = $request->jangkauan_detail ?? [];
            $jangkauanLainnya = $request->jangkauan_pemasaran_lainnya;

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
            $tahap2Data['jangkauan_pemasaran'] = json_encode($finalJangkauan);

            // Handle instansi (checkbox + detail)
            $instansi = [];
            if ($request->filled('instansi_check')) {
                foreach ($request->input('instansi_check') as $key) {
                    $instansi[$key] = $request->input("instansi_detail.$key");
                }
            }
            $tahap2Data['instansi'] = json_encode($instansi);

            // Handle file uploads
            $tahap2Data['foto_produk'] = $this->handleFileUploads($request->file('foto_produk', []), 'produk');
            $tahap2Data['foto_tempat_produksi'] = $this->handleFileUploads($request->file('foto_tempat_produksi', []), 'tempat');

            // Create Tahap2 record
            Tahap2::create($tahap2Data);

            // Commit transaction
            DB::commit();

            return redirect()->route('umkm.proses.index')->with('success', 'Data UMKM berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    protected function handleFileUploads($files, $prefix)
    {
        $paths = [];
        
        foreach ($files as $file) {
            if ($file->isValid()) {
                $filename = $prefix . '_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/uploads/foto_' . $prefix, $filename);
                $paths[] = str_replace('public/', '', $path);
            }
        }
        
        return json_encode($paths);
    }

}