<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use Illuminate\Http\Request;

class SpjController extends Controller
{
    public function index()
    {
        $spjs = Spj::all();
        return view('spj.index', compact('spjs'));
    }

    public function create()
    {
        return view('spj.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_spj' => 'required',
            'item' => 'required|string',
            'nominal' => 'required|numeric',
            'pembayaran' => 'required|in:Sudah,Belum',
            'keterangan' => 'nullable|string'
        ]);

        Spj::create($request->all());
        return redirect()->route('spj.index')->with('success', 'Data berhasil disimpan!');
    }
    public function edit($id)
{
    $spj = Spj::findOrFail($id);
    return view('spj.edit', compact('spj'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_spj' => 'required',
        'item' => 'required',
        'nominal' => 'required|numeric',
        'pembayaran' => 'required|in:Sudah,Belum',
        'keterangan' => 'nullable|string',
    ]);

    $spj = Spj::findOrFail($id);
    $spj->update($request->all());

    return redirect()->route('spj.index')->with('success', 'Data berhasil diupdate!');
}

public function destroy($id)
{
    $spj = Spj::findOrFail($id);
    $spj->delete();

    return redirect()->route('spj.index')->with('success', 'Data berhasil dihapus!');
}

}


//fgdgdfgd