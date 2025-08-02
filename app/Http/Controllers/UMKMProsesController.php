<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use App\Models\Tahap2;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UMKMProsesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $tahap1 = Tahap1::where('status', '!=', 'Tersertifikasi')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_pelaku', 'like', "%$search%")
                      ->orWhere('produk', 'like', "%$search%");
            })
            ->get();

        return view('umkm.proses.index', compact('tahap1'));
    }

    public function destroy($id)
    {
        $umkm = Tahap1::with('tahap2')->findOrFail($id);

        if ($umkm->status === 'Tersertifikasi') {
            return redirect()->back()->with('error', 'Data UMKM sudah tersertifikasi dan tidak dapat dihapus.');
        }

        $umkm->tahap2()->delete();
        $umkm->delete();

        return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data proses berhasil dihapus.');
    }

    public function createTahap($tahap, $id = null)
    {
        if (!$id && $tahap == 2) {
            return redirect()->route('umkm.proses.index')->with('error', 'Data Tahap 1 tidak ditemukan.');
        }

        $tahap1 = $id ? Tahap1::find($id) : null;
        $data = $tahap == 2 && $id ? Tahap2::where('pelaku_usaha_id', $id)->first() : null;
        $pelaku_usaha_id = $tahap1?->id;

        return view('tahap.create', compact('tahap', 'id', 'tahap1', 'data', 'pelaku_usaha_id'));
    }

    public function store(Request $request, int $tahap, $id = null)
    {
        return $tahap === 1
            ? $this->handleTahap1($request, $id)
            : $this->handleTahap2($request);
    }

    private function handleTahap1(Request $request, $id)
    {
        $isEdit = $id !== null;

        if ($request->has('riwayat_pembinaan') && is_array($request->riwayat_pembinaan)) {
            $request->merge([
                'riwayat_pembinaan' => implode(', ', $request->riwayat_pembinaan),
            ]);
        }

        $validated = $request->validate([
            'nama_pelaku' => 'nullable|string|max:255',
            'produk' => 'nullable|string|max:255',
            'klasifikasi' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'pembina_1' => 'nullable|string|max:255',
            'pembina_2' => 'nullable|string|max:255',
            'sinergi' => 'nullable|string|max:255',
            'nama_kontak_person' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:25',
            'bulan_pertama_pembinaan' => 'nullable|string|max:10',
            'tahun_dibina' => 'nullable|string|max:4',
            'riwayat_pembinaan' => 'nullable|string',
            'status_pembinaan' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'media_sosial' => 'nullable|string|max:255',
            'nama_merek' => 'nullable|string|max:255',
            'lspro' => 'nullable|string|max:255',
            'tanda_daftar_merk' => 'nullable|string|max:255',
        ]);

        $tahap1 = $isEdit
            ? tap(Tahap1::findOrFail($id))->update($validated)
            : Tahap1::create($validated);

        $nextId = $isEdit ? $id : $tahap1->id;

        return redirect()->route('admin.umkm.create.tahap', [
            'tahap' => 2,
            'id' => $nextId
        ])->with('success', 'Tahap 1 berhasil disimpan');
    }

    private function handleTahap2(Request $request)
    {
        $validated = $request->validate([
            'pelaku_usaha_id' => 'required|exists:tahap1,id',
            'omzet' => 'nullable|numeric',
            'volume_per_tahun' => 'nullable|string|max:255',
            'jumlah_tenaga_kerja' => 'nullable|integer',
            'jangkauan_pemasaran' => 'nullable|array',
            'jangkauan_pemasaran.*' => 'in:Local,Nasional,Internasional',
            'link_dokumen' => 'nullable|url|max:255',
            'alamat_kantor' => 'nullable|string|max:255',
            'provinsi_kantor' => 'nullable|string|max:255',
            'kota_kantor' => 'nullable|string|max:255',
            'alamat_pabrik' => 'nullable|string|max:255',
            'provinsi_pabrik' => 'nullable|string|max:255',
            'kota_pabrik' => 'nullable|string|max:255',
            'legalitas_usaha' => 'nullable|string|max:255',
            'tahun_pendirian' => 'nullable|string|max:4',
            'jenis_usaha' => 'nullable|in:Pangan,Nonpangan',
            'sni_yang_diterapkan' => 'nullable|string',
            'lspro' => 'nullable|string',
            'instansi' => 'nullable',
            'sertifikasi' => 'nullable|string',
            'foto_produk.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_tempat_produksi.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (is_array($request->instansi)) {
            $validated['instansi'] = json_encode($request->instansi);
        }

        $validated['jangkauan_pemasaran'] = $request->input('jangkauan_pemasaran', []);
        $validated['tanda_daftar_merek'] = $request->input('tanda_daftar_merek', []);
        $validated['foto_produk'] = json_encode($this->uploadFiles($request, 'foto_produk'));
        $validated['foto_tempat_produksi'] = json_encode($this->uploadFiles($request, 'foto_tempat_produksi'));

        Tahap2::updateOrCreate(
            ['pelaku_usaha_id' => $validated['pelaku_usaha_id']],
            $validated
        );

        return redirect()->route('umkm.proses.index')->with('success', 'Tahap 2 berhasil disimpan');
    }

    private function uploadFiles(Request $request, $field)
    {
        $paths = [];
        if ($request->hasFile($field)) {
            foreach ($request->file($field) as $file) {
                if ($file && $file->isValid()) {
                    $filename = Str::random(10) . '_' . $file->getClientOriginalName();
                    $file->storeAs($field, $filename, 'public');
                    $paths[] = $filename;
                }
            }
        }
        return $paths;
    }

    public function show($id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $id)->first();

        return view('umkm.sertifikasi.show', compact('tahap1', 'tahap2'));
    }

    public function update(Request $request, $id)
    {
        $tahap1 = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::firstOrNew(['pelaku_usaha_id' => $id]);

        $tahap1->update($request->only([
            'nama_pelaku','produk','klasifikasi','status','pembina_1','pembina_2',
            'sinergi','nama_kontak_person','no_hp','bulan_pertama_pembinaan',
            'tahun_dibina','riwayat_pembinaan','status_pembinaan','email',
            'media_sosial','nama_merek'
        ]));

        $data2 = $request->only([
            'omzet','volume_per_tahun','jumlah_tenaga_kerja','link_dokumen',
            'alamat_kantor','provinsi_kantor','kota_kantor',
            'alamat_pabrik','provinsi_pabrik','kota_pabrik',
            'legalitas_usaha','tahun_pendirian','jenis_usaha',
            'sni_yang_diterapkan','lspro','instansi','sertifikasi','produk'
        ]);

        $data2['jangkauan_pemasaran'] = $request->input('jangkauan_pemasaran', []);
        $data2['tanda_daftar_merek'] = $request->input('tanda_daftar_merek', []);
        $data2['foto_produk'] = $this->mergeOldWithNewFiles($request, $tahap2->foto_produk ?? [], 'foto_produk');
        $data2['foto_tempat_produksi'] = $this->mergeOldWithNewFiles($request, $tahap2->foto_tempat_produksi ?? [], 'foto_tempat_produksi');

        $tahap2->fill($data2)->save();

        if ($tahap1->status_pembinaan === '9. SPPT SNI') {
            Sertifikasi::updateOrCreate(
                ['pelaku_usaha_id' => $tahap1->id],
                array_merge($tahap1->toArray(), $data2)
            );
            $tahap1->update(['status' => 'Tersertifikasi']);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    private function mergeOldWithNewFiles(Request $request, $oldFiles, $field)
    {
        $old = $request->input("old_{$field}", json_decode($oldFiles, true) ?? []);
        $new = $this->uploadFiles($request, $field);
        return $old ? array_merge($old, $new) : $new;
    }
}
