<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Tahap1, Tahap2, Tahap3, Tahap4, Tahap5, Tahap6};

class ContcreateUmkm extends Controller
{
    /* ----------------------------------------------------------------
       Entry wizard –  GET  /tahap/create
       ---------------------------------------------------------------- */
    public function create()
    {
        // langsung buka form tahap‑1
        return redirect()->route('tahap.create.tahap', 1);
    }

    /* ----------------------------------------------------------------
       Tampilkan form sesuai tahap
       GET /tahap/create/{tahap}/{id?}
       ---------------------------------------------------------------- */
    public function showTahap(int $tahap, $id = null)
    {
        $data = null;

        switch ($tahap) {
            case 1: // tahap‑1 form kosong
                break;

            case 2:
                $data = Tahap2::where('pelaku_usaha_id', $id)->first();
                break;

            case 3:
                $data = Tahap3::where('pelaku_usaha_id', $id)->first();
                break;

            case 4:
                $data = Tahap4::where('pelaku_usaha_id', $id)->first();
                break;

            case 5:
                $data = Tahap5::where('riwayat_pembinaan_id', $id)->first();
                break;

            case 6:
                $data = Tahap6::where('pelaku_usaha_id', $id)->first();
                break;

            default:
                abort(404, 'Tahap tidak valid.');
        }

        return view('tahap.create', compact('tahap', 'data', 'id'));
    }

    /* ----------------------------------------------------------------
       Simpan data (tahap 1 – 6) – POST /tahap/store/{tahap}/{id?}
       ---------------------------------------------------------------- */
    public function store(Request $request, int $tahap, $id = null)
    {
        /* ---------- aturan validasi per‑tahap ---------- */
        $rules = [
           1 => [
                'nama_pelaku'  => 'required|string|max:100',
                'produk'       => 'required|string|max:100',
                'klasifikasi'  => 'required|string|max:100',
                'status'       => 'required|in:aktif,tidak_aktif',
                'provinsi'     => 'required|string|max:100',
            ],

            2 => ['nama_kontak'  => 'required|string|max:100',
                  'no_hp'        => 'required|string|max:25',
                  'email'        => 'nullable|email',
                  'media_sosial' => 'nullable|string|max:100'],

            3 => ['jenis_usaha'     => 'required|string|max:100',
                  'nama_merek'      => 'nullable|string|max:100',
                  'legalitas'       => 'nullable|string|max:100',
                  'tahun_pendirian' => 'nullable|digits:4',
                  'sni'             => 'boolean'],

            4 => ['bulan_pertama' => 'required|string',
                  'tahun_bina'    => 'required|digits:4',
                  'kegiatan'      => 'nullable|string',
                  'gruping'       => 'nullable|string'],

            5 => ['kegiatan' => 'required|string',
                  'gruping'  => 'nullable|string',
                  'tanggal'  => 'required|date',
                  'catatan'  => 'nullable|string'],

            6 => ['omzet_per_tahun' => 'nullable|numeric',
                  'volume_produksi' => 'nullable|integer',
                  'tenaga_kerja'    => 'nullable|integer',
                  'jangkauan_pasar' => 'nullable|string|max:100'],
        ];

        $validated = $request->validate($rules[$tahap] ?? []);
        $nextId    = $id;   // fallback

        /* ---------- simpan / update menurut tahap ---------- */
        switch ($tahap) {
            case 1:
                $t1     = Tahap1::create($validated);
                $nextId = $t1->id;
                break;

            case 2:
                $t2     = Tahap2::updateOrCreate(
                              ['pelaku_usaha_id' => $id], $validated);
                $nextId = $t2->pelaku_usaha_id;
                break;

            case 3:
                $t3     = Tahap3::updateOrCreate(
                              ['pelaku_usaha_id' => $id], $validated);
                $nextId = $t3->pelaku_usaha_id;
                break;

            case 4:
                $t4     = Tahap4::updateOrCreate(
                              ['pelaku_usaha_id' => $id], $validated);
                $nextId = $t4->pelaku_usaha_id;
                break;

            case 5:
                $t5     = Tahap5::updateOrCreate(
                              ['riwayat_pembinaan_id' => $id], $validated);
                $nextId = $t5->pembinaan_id;
                break;

            case 6:
                Tahap6::updateOrCreate(
                    ['pelaku_usaha_id' => $id], $validated);

                return redirect()
                       ->route('umkm.index')
                       ->with('success', 'Data UMKM selesai disimpan!');
        }

        /* ---------- redirect ke tahap selanjutnya ---------- */
        return redirect()->route('tahap.create.tahap', [
            'tahap' => $tahap + 1,
            'id'    => $nextId,
        ]);
    }
}
