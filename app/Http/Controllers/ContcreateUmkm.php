<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $data = match ($tahap) {
            1 => Tahap1::find($id),
            2 => Tahap2::where('pelaku_usaha_id', $id)->first(),
            3 => Tahap3::where('pelaku_usaha_id', $id)->first(),
            4 => Tahap4::where('pelaku_usaha_id', $id)->first(),
            5 => Tahap5::where('pelaku_usaha_id', $id)->first(),
            6 => Tahap6::where('pelaku_usaha_id', $id)->first(),
            default => abort(404, 'Tahap tidak valid.')
        };

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
                'produk' => 'nullable|string|max:100',
                'klasifikasi' => 'nullable|string|max:100',
                'status' => 'nullable|string|max:50',
                'pembina_1' => 'nullable|string|max:100',
            ],
            2 => [
                'pembina_2' => 'nullable|string|max:100',
                'sinergi' => 'nullable|string|max:100',
                'nama_kontak_person' => 'required|string|max:100',
                'No_Hp' => 'required|string|max:25',
                'bulan_pertama_pembinaan' => 'nullable|string|max:50',
            ],
            3 => [
                'status_pembinaan' => 'required|string',
                'tahun_dibina' => 'nullable|digits:4',
                'riwayat_pembinaan' => 'nullable|string',
                'email' => 'nullable|email',
                'media_sosial' => 'nullable|string|max:100',
            ],
            4 => [
                'alamat' => 'nullable|string|max:255',
                'provinsi' => 'nullable|string|max:100',
                'kota' => 'nullable|string|max:100',
                'legalitas_usaha' => 'nullable|string|max:100',
                'tahun_pendirian' => 'nullable|digits:4',
            ],
            5 => [
                'jenis_usaha' => 'nullable|string|max:100',
                'nama_merek' => 'nullable|string|max:100',
                'sni' => 'nullable|boolean',
                'lspro' => 'nullable|string|max:100',
                'tanda_daftar_merk' => 'nullable|boolean',
            ],
            6 => [
                'omzet' => 'required|numeric',
                'volume_per_tahun' => 'required|string|max:100',
                'jumlah_tenaga_kerja' => 'required|integer',
                'jangkauan_pemasaran' => 'required|string|max:100',
                'link_dokumen' => 'required|string|max:255',
                'foto_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'foto_tempat_produksi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
        ];

        $customMessages = [
            'foto_produk.image' => 'Kolom foto produk harus berupa gambar.',
            'foto_produk.mimes' => 'Foto produk harus berformat jpg, jpeg, atau png.',
            'foto_tempat_produksi.image' => 'Kolom foto tempat produksi harus berupa gambar.',
            'foto_tempat_produksi.mimes' => 'Foto tempat produksi harus berformat jpg, jpeg, atau png.',
        ];

        $validated = $request->validate($rules[$tahap] ?? [], $customMessages);
        $nextId = $id;

        switch ($tahap) {
            case 1:
                $t1 = $isEdit ? Tahap1::findOrFail($id)->update($validated) : Tahap1::create($validated);
                $nextId = $isEdit ? $id : $t1->id;
                break;

            case 2:
                $validated['pelaku_usaha_id'] = $id;
                $t2 = Tahap2::updateOrCreate(['pelaku_usaha_id' => $id], $validated);
                $nextId = $t2->pelaku_usaha_id;
                break;

            case 3:
                $validated['pelaku_usaha_id'] = $id;
                $t3 = Tahap3::updateOrCreate(['pelaku_usaha_id' => $id], $validated);
                $nextId = $t3->pelaku_usaha_id;
                break;

            case 4:
                $validated['pelaku_usaha_id'] = $id;
                $t4 = Tahap4::updateOrCreate(['pelaku_usaha_id' => $id], $validated);
                $nextId = $t4->pelaku_usaha_id;
                break;

            case 5:
                $validated['pelaku_usaha_id'] = $id;
                $validated['sni'] = $request->has('sni');
                $validated['tanda_daftar_merk'] = $request->has('tanda_daftar_merk');
                $t5 = Tahap5::updateOrCreate(['pelaku_usaha_id' => $id], $validated);
                $nextId = $t5->pelaku_usaha_id;
                break;

            case 6:
                $validated['pelaku_usaha_id'] = $id;

                $old = Tahap6::where('pelaku_usaha_id', $id)->first();

                // Foto produk
                if ($request->hasFile('foto_produk')) {
                    if ($old && $old->foto_produk) {
                        Storage::disk('public')->delete($old->foto_produk);
                    }
                    $filename = time() . '_produk.' . $request->file('foto_produk')->getClientOriginalExtension();
                    $path = $request->file('foto_produk')->storeAs('uploads/foto_produk', $filename, 'public');
                    $validated['foto_produk'] = $path;
                }

                // Foto tempat produksi
                if ($request->hasFile('foto_tempat_produksi')) {
                    if ($old && $old->foto_tempat_produksi) {
                        Storage::disk('public')->delete($old->foto_tempat_produksi);
                    }
                    $filename = time() . '_tempat.' . $request->file('foto_tempat_produksi')->getClientOriginalExtension();
                    $path = $request->file('foto_tempat_produksi')->storeAs('uploads/foto_tempat_produksi', $filename, 'public');
                    $validated['foto_tempat_produksi'] = $path;
                }

                Tahap6::updateOrCreate(['pelaku_usaha_id' => $id], $validated);

                if ($tahap < 6) {
                    return redirect()->route('tahap.create.tahap', ['tahap' => $tahap + 1, 'id' => $id])
                        ->with('success', 'Data berhasil disimpan!');
                } else {
                    return redirect()->route('umkm.proses.index')
                        ->with('success', 'Data UMKM berhasil ditambahkan!');
                }
                break;

            default:
                abort(404, 'Tahap tidak valid.');
        }

        return redirect()->route('tahap.create.tahap', [
            'tahap' => $tahap + 1,
            'id'    => $nextId,
        ]);
    }
}
