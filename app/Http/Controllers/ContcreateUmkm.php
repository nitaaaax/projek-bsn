<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Tahap1, Tahap2, Tahap3, Tahap4, Tahap5, Tahap6};

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
                $data = Tahap4::where('pelaku_usaha_id', $id)->first();
                break;
            case 5:
                $pembinaan = Tahap4::where('pelaku_usaha_id', $id)->first();
                $data = $pembinaan ? Tahap5::where('pembinaan_id', $pembinaan->id)->latest('tanggal')->first() : null;
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
                'nama_pelaku' => 'required|string|max:100',
                'produk'      => 'required|string|max:100',
                'klasifikasi' => 'required|string|max:100',
                'status'      => 'required|string|max:50',
                'provinsi'    => 'required|string|max:100',
            ],
            2 => [
                'nama_kontak'   => 'required|string|max:100',
                'no_hp'         => 'required|string|max:25',
                'email'         => 'nullable|email',
                'media_sosial'  => 'nullable|string|max:100',
            ],
            3 => [
                'jenis_usaha'      => 'required|string|max:100',
                'nama_merek'       => 'nullable|string|max:100',
                'legalitas'        => 'nullable|string|max:100',
                'tahun_pendirian'  => 'nullable|digits:4',
                'sni'              => 'nullable|boolean',
            ],
            4 => [
                'bulan_pertama' => 'required|string',
                'tahun_bina'    => 'required|digits:4',
                'kegiatan'      => 'nullable|string',
                'gruping'       => 'nullable|string',
            ],
            5 => [
                'kegiatan' => 'required|string',
                'gruping'  => 'nullable|string',
                'tanggal'  => 'required|date',
                'catatan'  => 'nullable|string',
            ],
            6 => [
                'omzet_per_tahun'  => 'nullable|numeric',
                'volume_produksi'  => 'nullable|string',
                'tenaga_kerja'     => 'nullable|integer',
                'jangkauan_pasar'  => 'nullable|string|max:100',
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
                $t3 = Tahap3::create($validated);
                $nextId = $t3->pelaku_usaha_id;
                break;
            case 4:
                $validated['pelaku_usaha_id'] = $id;
                $t4 = Tahap4::create($validated);
                $nextId = $t4->pelaku_usaha_id;
                break;
            case 5:
                $pembinaan = Tahap4::where('pelaku_usaha_id', $id)->first();
                if (!$pembinaan) {
                    return redirect()->back()->withErrors(['id' => 'Pembinaan tidak ditemukan untuk pelaku usaha ini.']);
                }
                $validated['pembinaan_id'] = $pembinaan->id;
                Tahap5::create($validated);
                $nextId = $pembinaan->id;
                break;
            case 6:
                $validated['pelaku_usaha_id'] = $id;
                Tahap6::create($validated);
                return redirect()->route('umkm.index')->with('success', 'Data UMKM selesai disimpan!');
            default:
                abort(404, 'Tahap tidak valid.');
        }

        return redirect()->route('tahap.create.tahap', [
            'tahap' => $tahap + 1,
            'id'    => $nextId,
        ]);
    }
}
