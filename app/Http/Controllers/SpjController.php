<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\SpjDetail;
use Illuminate\Http\Request;

class SpjController extends Controller
{
    // Menampilkan semua data SPJ
    public function index()
    {
        $spj = Spj::with('details')->get();
        return view('spj.index', compact('spj'));
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
            'no_ukd'               => 'required|string|max:255',
            'keterangan'           => 'nullable|string',
            'item.*'               => 'required|string',
            'nominal.*'            => 'required|numeric|min:0',
            'status_pembayaran.*'  => 'required|in:belum_dibayar,sudah_dibayar',
        ]);

        // Simpan SPJ utama
        $spj = Spj::create([
            'nama_spj'   => $request->nama_spj,
            'no_ukd'     => $request->no_ukd,
            'keterangan' => $request->keterangan,
        ]);

        // Simpan semua detail item
        foreach ($request->item as $i => $item) {
            SpjDetail::create([
                'spj_id'            => $spj->id,
                'item'              => $item,
                'nominal'           => $request->nominal[$i],
                'status_pembayaran' => $request->status_pembayaran[$i],
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
            'nama_spj'   => 'required|string|max:255',
            'no_ukd'     => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'item.*'     => 'required|string',
            'nominal.*'  => 'required|numeric|min:0',
            'pembayaran.*' => 'required|in:belum_dibayar,sudah_dibayar',
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
