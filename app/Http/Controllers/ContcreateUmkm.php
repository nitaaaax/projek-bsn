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
            $data = null;

            switch ($tahap) {
                case 1: $data = Tahap1::find($id); break;
                case 2: $data = Tahap2::where('pelaku_usaha_id', $id)->first(); break;
                case 3: $data = Tahap3::where('pelaku_usaha_id', $id)->first(); break;
                case 4: $data = Tahap4::where('pelaku_usaha_id', $id)->first(); break;
                case 5: $data = Tahap5::where('pelaku_usaha_id', $id)->first(); break;
                case 6: $data = Tahap6::where('pelaku_usaha_id', $id)->first(); break;
                default: abort(404, 'Tahap tidak valid.');
            }

            return view('tahap.create', [
                'tahap' => $tahap,
                'data' => $data,
                'id' => $id,
                'pelaku_usaha_id' => $id
            ]);
        }

public function store(Request $request, $step)
{
    $id = $request->input('id');

    $rules = [
        1 => [
            'nama_pelaku'       => 'required|string|max:255',
            'produk'            => 'required|string|max:255',
            'klasifikasi'       => 'required|string|max:255',
            'status'            => 'required|string|max:255',
            'pembina_1'         => 'required|string|max:255',
        ],
        2 => [
            'pelaku_usaha_id'   => 'nullable|exists:pelaku_usaha,id',
            'pembina_2'         => 'required|string|max:255',
            'sinergi'           => 'required|string|max:255',
            'nama_kontak_person'=> 'required|string|max:255',
            'No_Hp'             => 'required|string|max:255',
            'bulan__pertama_pembinaan' => 'required|string|max:255',
        ],
        3 => [
            'pelaku_usaha_id'   => 'nullable|exists:pelaku_usaha,id',
            'status_pembinaan'  => 'required|string|max:255',
            'pendamping'        => 'required|string|max:255',
            'sektor'            => 'required|string|max:255',
            'jenis_produk'      => 'required|string|max:255',
        ],
        4 => [
            'pelaku_usaha_id'   => 'nullable|exists:pelaku_usaha,id',
            'jalan'             => 'required|string|max:255',
            'kelurahan'         => 'required|string|max:255',
            'kecamatan'         => 'required|string|max:255',
            'kab_kota'          => 'required|string|max:255',
            'provinsi'          => 'required|string|max:255',
        ],
        5 => [
            'pelaku_usaha_id'   => 'nullable|exists:pelaku_usaha,id',
            'bentuk_usaha'      => 'required|string|max:255',
            'legalitas_usaha'   => 'required|string|max:255',
            'nib'               => 'required|string|max:255',
            'no_pirt'           => 'nullable|string|max:255',
            'tanda_daftar_merk' => 'required|boolean',
        ],
        6 => [
            'pelaku_usaha_id'        => 'nullable|exists:pelaku_usaha,id',
            'omzet'                  => 'required|numeric',
            'volume_per_tahun'       => 'required|string|max:100',
            'jumlah_tenaga_kerja'    => 'required|integer',
            'jangkauan_pemasaran'    => 'required|string|max:100',
            'link_dokumen'           => 'required|string|max:255',
            'foto_produk'            => 'nullable|image|max:2048',
            'foto_tempat_produksi'   => 'nullable|image|max:2048',
        ],
    ];

    $validated = $request->validate($rules[$step]);

    switch ($step) {
        case 1:
            $tahap1 = Tahap1::create($validated);
            return redirect()->route('umkm.create', ['step' => 2, 'id' => $tahap1->id]);

        case 2:
            $validated['pelaku_usaha_id'] = $id ?? $request->input('pelaku_usaha_id');
            Tahap2::updateOrCreate(['pelaku_usaha_id' => $validated['pelaku_usaha_id']], $validated);
            return redirect()->route('umkm.create', ['step' => 3, 'id' => $validated['pelaku_usaha_id']]);

        case 3:
            $validated['pelaku_usaha_id'] = $id ?? $request->input('pelaku_usaha_id');
            Tahap3::updateOrCreate(['pelaku_usaha_id' => $validated['pelaku_usaha_id']], $validated);
            return redirect()->route('umkm.create', ['step' => 4, 'id' => $validated['pelaku_usaha_id']]);

        case 4:
            $validated['pelaku_usaha_id'] = $id ?? $request->input('pelaku_usaha_id');
            Tahap4::updateOrCreate(['pelaku_usaha_id' => $validated['pelaku_usaha_id']], $validated);
            return redirect()->route('umkm.create', ['step' => 5, 'id' => $validated['pelaku_usaha_id']]);

        case 5:
            $validated['pelaku_usaha_id'] = $id ?? $request->input('pelaku_usaha_id');
            $validated['tanda_daftar_merk'] = (bool) $request->input('tanda_daftar_merk');
            Tahap5::updateOrCreate(['pelaku_usaha_id' => $validated['pelaku_usaha_id']], $validated);
            return redirect()->route('umkm.create', ['step' => 6, 'id' => $validated['pelaku_usaha_id']]);

        case 6:
            $validated['pelaku_usaha_id'] = $id ?? $request->input('pelaku_usaha_id');
            if (!$validated['pelaku_usaha_id']) {
                abort(400, 'pelaku_usaha_id wajib diisi di tahap 6!');
            }

            // Upload foto produk
            if ($request->hasFile('foto_produk')) {
                $validated['foto_produk'] = $request->file('foto_produk')->store('uploads/foto_produk', 'public');
            }

            // Upload foto tempat produksi
            if ($request->hasFile('foto_tempat_produksi')) {
                $validated['foto_tempat_produksi'] = $request->file('foto_tempat_produksi')->store('uploads/foto_tempat_produksi', 'public');
            }

            // Simpan ke DB
            Tahap6::updateOrCreate(
                ['pelaku_usaha_id' => $validated['pelaku_usaha_id']],
                $validated
            );

            // Update status UMKM jika sudah SPPT SNI
            $status = Tahap3::where('pelaku_usaha_id', $validated['pelaku_usaha_id'])->value('status_pembinaan');
            if ($status === '8. SPPT SNI') {
                Tahap1::where('id', $validated['pelaku_usaha_id'])->update(['status' => 'Tersertifikasi']);
            }

            return redirect()->route('umkm.proses.index')->with('success', 'Data UMKM berhasil disimpan!');
    }
}

    }
