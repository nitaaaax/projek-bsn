<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Tahap1, Tahap2, Tahap3, Tahap4, Tahap6, LegalitasUsaha};

class ContcreateUmkm extends Controller
{
    public function index()
    {
        $tahap = Tahap1::count();
        return view('tahap.create', compact('tahap'));
    }

    public function create()
    {
        return redirect()->route('tahap.create.tahap', 1);
    }

    public function showTahap(int $tahap, $id = null)
    {
        $data = null;

        switch ($tahap) {
            case 1:
                $data = Tahap1::find($id);
                break;
            case 2:
                $data = Tahap2::where('pelaku_usaha_id', $id)->first();
                break;
            case 3:
                $data = Tahap3::where('pelaku_usaha_id', $id)->first();
                break;
            case 4:
                $data = LegalitasUsaha::where('pelaku_usaha_id', $id)->first();
                break;
            case 5:
                $data = LegalitasUsaha::where('pelaku_usaha_id', $id)->first(); // tetap pakai LegalitasUsaha
                break;
            case 6:
                $data = Tahap6::where('pelaku_usaha_id', $id)->first();
                break;
            default:
                abort(404, 'Tahap tidak valid.');
        }

        return view('tahap.create', compact('tahap', 'data', 'id'));
    }

    public function store(Request $request, int $tahap, $id = null)
    {
        $rules = [
            1 => [
                'nama_pelaku' => 'nullable|string|max:100',
                'produk'      => 'nullable|string|max:100',
                'klasifikasi' => 'nullable|string|max:100',
                'status'      => 'nullable|string|max:50',
                'pembina_1'   => 'nullable|string|max:100',
            ],
            2 => [
                'pembina_2'     => 'nullable|string|max:100',
                'sinergi'       => 'nullable|string|max:100',
                'nama_kontak'   => 'required|string|max:100',
                'no_hp'         => 'required|string|max:25',
            ],
            3 => [
                'bulan_pembinaan'     => 'nullable|string',
                'tahun_dibina'        => 'nullable|digits:4',
                'riwayat_pembinaan'   => 'nullable|string',
                'gruping'             => 'nullable|string',
                'email'               => 'nullable|email',
                'media_sosial'        => 'nullable|string|max:100',
            ],
            4 => [
                'jenis_usaha'      => 'nullable|string|max:100',
                'nama_merek'       => 'nullable|string|max:100',
                'legalitas'        => 'nullable|string|max:100',
                'tahun_pendirian'  => 'nullable|digits:4',
                'sni'              => 'nullable|boolean',
            ],
            5 => [
                'lspro' => 'nullable|string|max:100',
            ],
            6 => [
                'omzet_per_tahun'   => 'nullable|numeric',
                'volume_produksi'   => 'nullable|string|max:100',
                'tenaga_kerja'      => 'nullable|integer',
                'jangkauan_pasar'   => 'nullable|string|max:100',
                'link_dokumen_mutu' => 'nullable|string|max:255',
            ],
        ];

        $validated = $request->validate($rules[$tahap] ?? []);
        $nextId = $id;

        switch ($tahap) {
            case 1:
                $t1 = Tahap1::create($validated);
                $nextId = $t1->id;
                break;

            case 2:
                $validated['pelaku_usaha_id'] = $id;
                $t2 = Tahap2::create($validated);
                $nextId = $t2->pelaku_usaha_id;
                break;

            case 3:
                $validated['pelaku_usaha_id'] = $id;
                $validated['bulan_pertama'] = $validated['bulan_pembinaan'] ?? null;
                $validated['tahun_bina'] = $validated['tahun_dibina'] ?? null;
                $validated['kegiatan'] = $validated['riwayat_pembinaan'] ?? null;
                unset($validated['bulan_pembinaan'], $validated['tahun_dibina'], $validated['riwayat_pembinaan']);
                $t3 = Tahap3::create($validated);
                $nextId = $t3->pelaku_usaha_id;
                break;

            case 4:
                $validated['pelaku_usaha_id'] = $id;
                $validated['sni'] = $request->has('sni');
                $t4 = LegalitasUsaha::create($validated);
                $nextId = $t4->pelaku_usaha_id;
                break;

            case 5:
                $legalitas = LegalitasUsaha::where('pelaku_usaha_id', $id)->first();
                if ($legalitas) {
                    $legalitas->update($validated);
                    $nextId = $legalitas->pelaku_usaha_id;
                }
                break;

            case 6:
                $validated['pelaku_usaha_id'] = $id;
                Tahap6::create($validated);
                return redirect()->route('umkm.index')->with('success', 'Data UMKM berhasil disimpan!');

            default:
                abort(404, 'Tahap tidak valid.');
        }

        return redirect()->route('tahap.create.tahap', [
            'tahap' => $tahap + 1,
            'id'    => $nextId,
        ]);
    }
}
