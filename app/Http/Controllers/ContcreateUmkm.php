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
        return redirect()->route('tahap.create.tahap', ['tahap' => 1]);
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
                $data = Tahap5::where('pelaku_usaha_id', $id)->first();
                break;
            case 6:
                $data = Tahap6::where('pelaku_usaha_id', $id)->first();
                break;
            default:
                abort(404, 'Tahap tidak valid.');
        }

        return view('tahap.create', [
            'tahap' => $tahap,
            'data' => $data,
            'id' => $id,
            'pelaku_usaha_id' => $id
        ]);
    }

    public function store(Request $request, int $tahap, $id = null)
    {
        $isEdit = $id !== null;

        $rules = [
            1 => [
                'nama_pelaku' => 'nullable|string|max:100',
                'produk'      => 'nullable|string|max:100',
                'klasifikasi' => 'nullable|string|max:100',
                'status'      => 'nullable|string|max:50',
                'pembina_1'   => 'nullable|string|max:100',
            ],
            2 => [
                'pembina_2'               => 'nullable|string|max:100',
                'sinergi'                 => 'nullable|string|max:100',
                'nama_kontak_person'     => 'required|string|max:100',
                'No_Hp'                   => 'required|string|max:25',
                'bulan_pertama_pembinaan'=> 'nullable|string|max:50',
            ],
            3 => [
                'bulan_pembinaan'    => 'nullable|string',
                'tahun_dibina'       => 'nullable|digits:4',
                'riwayat_pembinaan'  => 'nullable|string',
                'status_pembinaan'   => 'nullable|string',
                'email'              => 'nullable|email',
                'media_sosial'       => 'nullable|string|max:100',

            ],
            4 => [
                'alamat'           => 'nullable|string|max:255',
                'provinsi'         => 'nullable|string|max:100',
                'kota'             => 'nullable|string|max:100',
                'legalitas_usaha'  => 'nullable|string|max:100',
                'tahun_pendirian'  => 'nullable|digits:4',
            ],
            5 => [
                'jenis_usaha' => 'nullable|string|max:100',
                'nama_merek'  => 'nullable|string|max:100',
                'sni'         => 'nullable|boolean',
                'lspro'       => 'nullable|string|max:100',
            ],
            6 => [
                'omzet'               => 'required|numeric',
                'volume_per_tahun'    => 'required|string|max:100',
                'jumlah_tenaga_kerja' => 'required|integer',
                'jangkauan_pemasaran' => 'required|string|max:100',
                'link_dokumen'        => 'required|string|max:255',
            ],
        ];

        $validated = $request->validate($rules[$tahap] ?? []);
        $nextId = $id;

        switch ($tahap) {
            case 1:
                if ($isEdit) {
                    $t1 = Tahap1::findOrFail($id);
                    $t1->update($validated);
                } else {
                    $t1 = Tahap1::create($validated);
                }
                $nextId = $t1->id;
                break;

            case 2:
                $validated['pelaku_usaha_id'] = $id;
                $t2 = Tahap2::updateOrCreate(
                    ['pelaku_usaha_id' => $id],
                    $validated
                );
                $nextId = $t2->pelaku_usaha_id;
                break;

            case 3:
                $validated = $request->validate([
                    'status_pembinaan' => 'required|string',
                    // tambahkan field lain kalau ada (misal 'catatan', dll)
                ]);

                $validated['pelaku_usaha_id'] = $id;

                $t3 = Tahap3::updateOrCreate(
                    ['pelaku_usaha_id' => $id],
                    $validated
                );

                $nextId = $t3->pelaku_usaha_id;
                break;



            case 4:
                $validated['pelaku_usaha_id'] = $id;
                $validated['sni'] = $request->has('sni');
                $t4 = Tahap4::updateOrCreate(
                    ['pelaku_usaha_id' => $id],
                    $validated
                );
                $nextId = $t4->pelaku_usaha_id;
                break;

            case 5:
                $validated['pelaku_usaha_id'] = $id;
                $validated['sni'] = $request->has('sni');
                $t5 = Tahap5::updateOrCreate(
                    ['pelaku_usaha_id' => $id],
                    $validated
                );
                $nextId = $t5->pelaku_usaha_id;
                break;

            case 6:
                $validated['pelaku_usaha_id'] = $id ?? $request->input('pelaku_usaha_id');

                if (!$validated['pelaku_usaha_id']) {
                    abort(400, 'pelaku_usaha_id wajib diisi di tahap 6!');
                }

                $t6 = Tahap6::updateOrCreate(
                    ['pelaku_usaha_id' => $validated['pelaku_usaha_id']],
                    $validated
                );
                // Ambil status pembinaan dari tahap 3
                $pelakuUsahaId = $validated['pelaku_usaha_id'];
                $status = Tahap3::where('pelaku_usaha_id', $pelakuUsahaId)->value('status_pembinaan');

                if ($status === '8. SPPT SNI') {
                    Tahap1::where('id', $pelakuUsahaId)->update(['status' => 'Tersertifikasi']);
                }

                $nextId = $t6->pelaku_usaha_id;

                return redirect()->route('umkm.proses.index')->with('success', 'Data UMKM berhasil disimpan!');

            default:
                abort(404, 'Tahap tidak valid.');
        }

        return redirect()->route('tahap.create.tahap', [
            'tahap' => $tahap + 1,
            'id'    => $nextId,
        ]);
    }
}
