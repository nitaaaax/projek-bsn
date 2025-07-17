<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\SpjDetail;
use Illuminate\Http\Request;
use App\Exports\SpjExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SpjImport;

class SpjController extends Controller
{
    // Menampilkan semua data SPJ
    public function index()
    {
        $spj = Spj::with('details')->get();

        // Ambil semua detail yang sudah/ belum dibayar
        $sudahBayar = SpjDetail::with('spj')
                        ->where('status_pembayaran', 'sudah_dibayar')->get();

        $belumBayar = SpjDetail::with('spj')
                        ->where('status_pembayaran', 'belum_dibayar')->get();

        return view('spj.index', compact('spj', 'sudahBayar', 'belumBayar'));
    }

    public function spjexport(){
        return Excel::download(new SpjExport,'spj.xlsx');
    }

    public function spjimportexcel(Request $request)
    {
        // Validasi file harus ada dan bertipe Excel
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        // Jalankan proses import langsung dari file upload
        Excel::import(new SpjImport, $request->file('file'));

        return redirect()->route('spj.index')->with('success', 'Data berhasil diimpor.');
    }


    // Form tambah SPJ
    public function create()
    {
        return view('spj.create');
    }

    // Simpan data SPJ dan semua detailnya
    public function store(Request $request)
    {
        $request->validate([
            'nama_spj'             => 'required|string|max:255',
            'no_ukd'               => 'nullable|string|max:255',
            'keterangan'           => 'nullable|string',
            'item.*'               => 'required|string',
            'nominal.*'            => 'required|numeric|min:0',
            'status_pembayaran.*'  => 'required|in:belum_dibayar,sudah_dibayar',
            'keterangan_detail.*'  => 'nullable|string',
            'dokumen'              => 'nullable|string|max:255',
        ]);

        // Simpan data utama SPJ
        $spj = Spj::create([
            'nama_spj'   => $request->nama_spj,
            'no_ukd'     => $request->no_ukd,
            'keterangan' => $request->keterangan,
            'dokumen'    => $request->dokumen, // ini yang ditambahkan
        ]);

        // Simpan detail SPJ
        foreach ($request->item as $i => $item) {
            SpjDetail::create([
                'spj_id'            => $spj->id,
                'item'              => $item,
                'nominal'           => $request->nominal[$i],
                'status_pembayaran' => $request->status_pembayaran[$i],
                'keterangan'        => $request->keterangan_detail[$i] ?? null,
            ]);
        }

        return redirect()->route('spj.index')->with('success', 'Data SPJ berhasil disimpan.');
    }

    // Tampilkan detail SPJ
    public function show($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        return view('spj.show', compact('spj'));
    }

    // Form edit SPJ
    public function edit($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        return view('spj.edit', compact('spj'));
    }

    // Update SPJ dan semua detail item-nya
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_spj'      => 'required|string|max:255',
            'no_ukd'        => 'nullable|string|max:255',
            'keterangan'    => 'nullable|string',
            'item.*'        => 'required|string',
            'nominal.*'     => 'required|numeric|min:0',
            'pembayaran.*'  => 'required|in:belum_dibayar,sudah_dibayar',
        ]);

        $spj = Spj::findOrFail($id);
        $spj->update([
            'nama_spj'   => $request->nama_spj,
            'no_ukd'     => $request->no_ukd,
            'keterangan' => $request->keterangan,
        ]);

        // Hapus semua detail lama
        $spj->details()->delete();

        // Simpan ulang semua detail
        foreach ($request->item as $i => $item) {
            SpjDetail::create([
                'spj_id'            => $spj->id,
                'item'              => $item,
                'nominal'           => $request->nominal[$i],
                'status_pembayaran' => $request->pembayaran[$i],
            ]);
        }

        return redirect()->route('spj.show', $spj->id)->with('success', 'SPJ berhasil diupdate.');
    }

    // Hapus SPJ dan semua detailnya
    public function destroy($id)
    {
        $spj = Spj::findOrFail($id);
        $spj->details()->delete();
        $spj->delete();

        return redirect()->route('spj.index')->with('success', 'Data berhasil dihapus.');
    }
}
