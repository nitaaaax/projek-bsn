<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use Illuminate\Http\Request;
use App\Models\SpjDetail;

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
            'pembayaran' => 'required',
            'item.*' => 'required',
            'nominal.*' => 'required|numeric'
        ]);

        $spj = Spj::create([
            'nama_spj' => $request->nama_spj,
            'pembayaran' => $request->pembayaran,
            'keterangan' => $request->keterangan,
        ]);

        foreach ($request->item as $i => $item) {
            SpjDetail::create([
                'spj_id' => $spj->id,
                'item' => $item,
                'nominal' => $request->nominal[$i],
            ]);
        }

        return redirect()->route('spj.index');
    }

    public function show($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        return view('spj.show', compact('spj'));
    }
}
