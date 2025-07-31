<?php

namespace  App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Tahap1;
    use App\Models\Tahap2;

    class ContdataUmkm extends Controller
    {
    public function createTahap(Request $request, $tahap, $id = null)
    {
        $tahapNumber = $tahap; // <== Ini WAJIB ada
        $data = null;
        $pelaku_usaha_id = null;

        if ($tahap == 1) {
            if ($id) {
                $data = Tahap1::findOrFail($id);
                $pelaku_usaha_id = $data->id;
            }
        } elseif ($tahap == 2) {
            $data = Tahap2::where('pelaku_usaha_id', $id)->first();
            $pelaku_usaha_id = $id;
        }

        return view('tahap.create', [
            'data' => $data,
            'tahapNumber' => $tahapNumber,
            'id' => $id,
            'pelaku_usaha_id' => $pelaku_usaha_id,
        ]);
    }



        public function store(Request $request, $tahap)
        {
            
            if ($tahap == 1) {
                $validated = $request->validate([
                    'nama_pelaku' => 'nullable|string|max:255',
                    'produk' => 'nullable|string|max:255',
                    'klasifikasi' => 'nullable|string',
                    'status' => 'nullable|string',
                    'pembina_1' => 'nullable|string',
                    'pembina_2' => 'nullable|string',
                    'sinergi' => 'nullable|string',
                    'nama_kontak_person' => 'nullable|string',
                    'no_hp' => 'nullable|string',
                    'bulan_pertama_pembinaan' => 'nullable|string',
                    'tahun_dibina' => 'nullable|string',
                    'riwayat_pembinaan' => 'nullable|string',
                    'status_pembinaan' => 'nullable|string',
                    'email' => 'nullable|email',
                    'media_sosial' => 'nullable|string',
                    'nama_merek' => 'nullable|string',
                    
                ]);

                // Update jika ada id, atau create baru
                if ($request->pelaku_usaha_id) {
                    $tahap1 = Tahap1::findOrFail($request->pelaku_usaha_id);
                    $tahap1->update($validated);
                } else {
                    $tahap1 = Tahap1::create($validated);
                }

                return redirect()->route('tahap.create.tahap', ['tahap' => 2, 'id' => $tahap1->id])
                                ->with('success', 'Tahap 1 berhasil disimpan');
            }

            if ($tahap == 2) {
                if (!$request->has('jangkauan_pemasaran')) {
        $request->merge(['jangkauan_pemasaran' => []]);
    }

                $validated = $request->validate([
                    'pelaku_usaha_id' => 'required|exists:tahap1,id',
                    'omzet' => 'nullable|numeric',
                    'volume_per_tahun' => 'nullable|numeric',
                    'jumlah_tenaga_kerja' => 'nullable|numeric',
                    'jangkauan_pemasaran' => 'nullable|array',
                    'jangkauan_pemasaran.*' => 'in:Local,Nasional,Internasional',
                    'link_dokumen' => 'nullable|url',
                    'alamat_kantor' => 'nullable|string',
                    'provinsi_kantor' => 'nullable|string',
                    'kota_kantor' => 'nullable|string',
                    'alamat_pabrik' => 'nullable|string',
                    'provinsi_pabrik' => 'nullable|string',
                    'kota_pabrik' => 'nullable|string',
                    'legalitas_usaha' => 'nullable|string',
                    'tahun_pendirian' => 'nullable|string',
                    'foto_produk' => 'nullable|array',
                    'foto_produk.*' => 'image|mimes:jpg,jpeg,png',
                    'foto_tempat_produksi' => 'nullable|array',
                    'foto_tempat_produksi.*' => 'image|mimes:jpg,jpeg,png',
                    'jenis_usaha' => 'nullable|string',
                    'sni_yang_akan_diterapkan' => 'nullable|string',
                    'lspro' => 'nullable|string',
                    'tanda_daftar_merek' => 'nullable|string',
                ]);

                // Upload foto produk
                $foto_produk = [];
                if ($request->hasFile('foto_produk')) {
                    foreach ($request->file('foto_produk') as $foto) {
                        $foto_produk[] = $foto->store('uploads/foto_produk', 'public');
                    }
                }

                // Upload foto tempat produksi
                $foto_tempat = [];
                if ($request->hasFile('foto_tempat_produksi')) {
                    foreach ($request->file('foto_tempat_produksi') as $foto) {
                        $foto_tempat[] = $foto->store('uploads/foto_tempat', 'public');
                    }
                }

            $validated['foto_produk'] = json_encode($foto_produk);
            $validated['foto_tempat_produksi'] = json_encode($foto_tempat);

                // Update atau buat baru data Tahap2
                $validated['jangkauan_pemasaran'] = json_encode($validated['jangkauan_pemasaran']);

                $tahap2 = Tahap2::updateOrCreate(
                    ['pelaku_usaha_id' => $validated['pelaku_usaha_id']],
                    $validated
                );

                return redirect()->route('umkm.proses.index')->with('success', 'UMKM berhasil disimpan');
            }

            abort(404, 'Tahap tidak valid.');
        }
        
        public function show($id)
        {
            $tahap1 = Tahap1::findOrFail($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();
            $pelaku_usaha_id = $tahap1->id;

            // Cegah error jika data sudah dalam bentuk array
            $foto_produk = [];
            if ($tahap2 && !empty($tahap2->foto_produk)) {
                $foto_produk = is_string($tahap2->foto_produk)
                    ? json_decode($tahap2->foto_produk, true)
                    : (is_array($tahap2->foto_produk) ? $tahap2->foto_produk : []);
            }

            $foto_tempat_produksi = [];
            if ($tahap2 && !empty($tahap2->foto_tempat_produksi)) {
                $foto_tempat_produksi = is_string($tahap2->foto_tempat_produksi)
                    ? json_decode($tahap2->foto_tempat_produksi, true)
                    : (is_array($tahap2->foto_tempat_produksi) ? $tahap2->foto_tempat_produksi : []);
            }

            $jangkauan = [];
            if ($tahap2 && !empty($tahap2->jangkauan_pemasaran)) {
                $jangkauan = is_string($tahap2->jangkauan_pemasaran)
                    ? json_decode($tahap2->jangkauan_pemasaran, true)
                    : (is_array($tahap2->jangkauan_pemasaran) ? $tahap2->jangkauan_pemasaran : []);
            }

            return view('umkm.show', compact(
                'tahap1', 'tahap2', 'pelaku_usaha_id',
                'foto_produk', 'foto_tempat_produksi', 'jangkauan'
            ));
        }




        public function destroy($id)
        {
            // Hapus data tahap 2 yang berkaitan
            Tahap2::where('pelaku_usaha_id', $id)->delete();

            // Hapus data dari tahap 1 (pelaku_usaha)
            Tahap1::findOrFail($id)->delete();

            return redirect()->back()->with('success', 'Data UMKM berhasil dihapus');
        }
        
            public function edit($id)
        {
            $tahap1 = Tahap1::findOrFail($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

            $tanda_merk = $tahap2 && $tahap2->tanda_daftar_merk ? json_decode($tahap2->tanda_daftar_merk, true) : [];
            $foto_produk = $tahap2 && $tahap2->foto_produk ? json_decode($tahap2->foto_produk, true) : [];
            $foto_tempat_produksi = $tahap2 && $tahap2->foto_tempat_produksi ? json_decode($tahap2->foto_tempat_produksi, true) : [];

            return view('umkm.index', compact(
                'tahap1', 'tahap2',
                'foto_produk', 'foto_tempat_produksi', 'tanda_merk'
            ));
        }



        public function update(Request $request, $id)
        {
            
            $tahap1 = Tahap1::findOrFail($id);

            $validated1 = $request->validate([
                'nama_pelaku' => 'nullable|string|max:255',
                'produk' => 'nullable|string|max:255',
                'klasifikasi' => 'nullable|string',
                'status' => 'nullable|string',
                'pembina_1' => 'nullable|string',
                'pembina_2' => 'nullable|string',
                'sinergi' => 'nullable|string',
                'nama_kontak_person' => 'nullable|string',
                'no_hp' => 'nullable|string',
                'bulan_pertama_pembinaan' => 'nullable|string',
                'tahun_dibina' => 'nullable|string',
                'status_pembinaan' => 'nullable|string',
                'email' => 'nullable|email',
                'media_sosial' => 'nullable|string',
                'nama_merek' => 'nullable|string',
                'riwayat_pembinaan' => 'nullable|string',

            
            ]);

            $tahap1->update($validated1);

            if (!$request->has('jangkauan_pemasaran')) {
                $request->merge(['jangkauan_pemasaran' => []]);
            }

            $validated2 = $request->validate([
                'omzet' => 'nullable|numeric',
                'volume_per_tahun' => 'nullable|numeric',
                'jumlah_tenaga_kerja' => 'nullable|numeric',
                'jangkauan_pemasaran' => 'nullable|array',
                'jangkauan_pemasaran.*' => 'in:Local,Nasional,Internasional',
                'link_dokumen' => 'nullable|url',
                'alamat_kantor' => 'nullable|string',
                'provinsi_kantor' => 'nullable|string',
                'kota_kantor' => 'nullable|string',
                'alamat_pabrik' => 'nullable|string',
                'provinsi_pabrik' => 'nullable|string',
                'kota_pabrik' => 'nullable|string',
                'legalitas_usaha' => 'nullable|string',
                'tahun_pendirian' => 'nullable|string',
                'foto_produk' => 'nullable|array',
                'foto_produk.*' => 'image|mimes:jpg,jpeg,png',
                'foto_tempat_produksi' => 'nullable|array',
                'foto_tempat_produksi.*' => 'image|mimes:jpg,jpeg,png',
                'jenis_usaha' => 'nullable|string',
                'sni_yang_akan_diterapkan' => 'nullable|string',
                'lspro' => 'nullable|string',
                'tanda_daftar_merk' => 'nullable|array',
                'tanda_daftar_merk.*' => 'string|max:255',
                'instansi' => 'nullable|string|max:255',
                'sertifikat' => 'nullable|string|max:255'
            ]);

            

            // Upload ulang gambar jika ada input baru
        if ($request->hasFile('foto_produk')) {
        foreach ($request->file('foto_produk') as $foto) {
            $foto_produk[] = $foto->store('uploads/foto_produk', 'public');
        }
        $validated2['foto_produk'] = json_encode($foto_produk);
    }

    if ($request->hasFile('foto_tempat_produksi')) {
        foreach ($request->file('foto_tempat_produksi') as $foto) {
            $foto_tempat[] = $foto->store('uploads/foto_tempat', 'public');
        }
        $validated2['foto_tempat_produksi'] = json_encode($foto_tempat);
    }

            $validated2['pelaku_usaha_id'] = $id;
            $validated2['jangkauan_pemasaran'] = $validated2['jangkauan_pemasaran']; // biarkan Laravel handle cast array

            Tahap2::updateOrCreate(
                ['pelaku_usaha_id' => $id],
                $validated2
            );

            return redirect()->route('umkm.index')->with('success', 'Data UMKM berhasil diperbarui.');
        }


    public function detailTahap(int $tahap, int $id)
    {
        $tahapNumber = $tahap;
        $pelaku_usaha_id = null;

        // Default null supaya aman
        $tahap1 = null;
        $tahap2 = null;
        $foto_produk = [];
        $foto_tempat_produksi = [];
        $jangkauan = [];

        if ($tahap == 1) {
            $tahap1 = Tahap1::findOrFail($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();
            $pelaku_usaha_id = $tahap1->id;
        } elseif ($tahap == 2) {
            $tahap1 = Tahap1::findOrFail($id);
            $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->firstOrFail();
            $pelaku_usaha_id = $id;
        } else {
            abort(404, 'Tahap tidak valid');
        }

        // Decode JSON supaya Blade bisa baca array
        if ($tahap2) {
            $foto_produk = $tahap2->foto_produk ? json_decode($tahap2->foto_produk, true) : [];
            $foto_tempat_produksi = $tahap2->foto_tempat_produksi ? json_decode($tahap2->foto_tempat_produksi, true) : [];
            $jangkauan = $tahap2->jangkauan_pemasaran ? json_decode($tahap2->jangkauan_pemasaran, true) : [];
        }

        return view('umkm.show', compact(
            'tahap1', 'tahap2', 'pelaku_usaha_id',
            'foto_produk', 'foto_tempat_produksi', 'jangkauan'
        ));
    }



    }
