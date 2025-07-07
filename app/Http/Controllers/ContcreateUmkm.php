<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahap1;
use App\Models\Tahap2;
use App\Models\Tahap3;
use App\Models\Tahap4;
use App\Models\Tahap5;
use App\Models\Tahap6;

class ContcreateUmkm extends Controller
{
    public function index()
    {
       $tahap = Tahap1::count();
       

        return view('tahap.create', compact('tahap'));
    }

    public function create()
    {
        return redirect()->route('umkm.create.tahap', 1);
    }

    public function store(Request $request, int $tahap, $id = null)
    {
        $rules = [
            1 => [
                'nama_pelaku' => 'required|string|max:100',
                'produk'      => 'required|string|max:100',
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
                'sni'              => 'boolean',
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
                'volume_produksi'  => 'nullable|integer',
                'tenaga_kerja'     => 'nullable|integer',
                'jangkauan_pasar'  => 'nullable|string|max:100',
            ],
        ];

        

        $validated = $request->validate($rules[$tahap] ?? []);

        $nextId = $id; // default fallback

        switch ($tahap) {
            case 1:
                $t1 = Tahap1::create($validated);
                $nextId = $t1->id;
                break;

            case 2:
                $t2 = Tahap2::updateOrCreate(
                    ['pelaku_usaha_id' => $id],
                    $validated
                );
                $nextId = $t2->pelaku_usaha_id;
                break;

            case 3:
                $t3 = Tahap3::updateOrCreate(
                    ['pelaku_usaha_id' => $id],
                    $validated
                );
                $nextId = $t3->pelaku_usaha_id;
                break;

            case 4:
                $t4 = Tahap4::updateOrCreate(
                    ['pelaku_usaha_id' => $id],
                    $validated
                );
                $nextId = $t4->pelaku_usaha_id;
                break;

            case 5:
                $t5 = Tahap5::updateOrCreate(
                    ['pembinaan_id' => $id],
                    $validated
                );
                $nextId = $t5->pembinaan_id;
                break;

            case 6:
                Tahap6::updateOrCreate(
                    ['pelaku_usaha_id' => $id],
                    $validated
                );
                return redirect()->route('umkm.index')
                                ->with('success', 'Data UMKM selesai disimpan!');
                break;

            default:
                abort(404, 'Tahap tidak valid.');
        }

        return redirect()->route('umkm.create.tahap', [
            'tahap' => $tahap + 1,
            'id'    => $nextId,
        ]);
    }

        public function showTahap(int $tahap, $id = null)
    {
        $data = null;

        switch ($tahap) {
            case 1: // form tahap‑1 kosong
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
                $data = Tahap5::where('pembinaan_id', $id)->first();
                break;

            case 6:
                $data = Tahap6::where('pelaku_usaha_id', $id)->first();
                break;

            default:
                abort(404, 'Tahap tidak valid.');
        }

        return view('tahap.create', compact('tahap', 'data', 'id'));
    }



}
