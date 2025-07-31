<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\SpjDetail;
use Illuminate\Http\Request;
use App\Exports\SpjExport;
use App\Imports\SpjImport;
use Maatwebsite\Excel\Facades\Excel;

class SpjController extends Controller
{
    public function index()
    {
        $spj = Spj::with('details')->get();

        $sudahBayar = SpjDetail::with('spj')
            ->where('status_pembayaran', 'Sudah Dibayar')->get();

        $belumBayar = SpjDetail::with('spj')
            ->where('status_pembayaran', 'Belum Dibayar')->get();

        return view('spj.index', compact('spj', 'sudahBayar', 'belumBayar'));
    }

    public function export()
    {
        return Excel::download(new SpjExport, 'spj_cair.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new SpjImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data berhasil diimpor!');
    }

    public function create()
    {
        return view('spj.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_spj'             => 'required|string|max:255',
            'no_ukd'               => 'nullable|string|max:255',
            'keterangan'           => 'nullable|string',
            'dokumen'              => 'nullable|string|max:255',
            'item.*'               => 'required|string',
            'nominal.*'            => 'required|numeric|min:0',
            'status_pembayaran.*'  => 'required|string',
            'keterangan_detail.*'  => 'nullable|string',
        ]);

        $spj = Spj::create([
            'nama_spj'   => $request->nama_spj,
            'no_ukd'     => $request->no_ukd,
            'keterangan' => $request->keterangan,
            'dokumen'    => $request->dokumen,
        ]);

        foreach ($request->item as $i => $item) {
            $status = strtolower(trim($request->status_pembayaran[$i] ?? ''));

            switch ($status) {
                case 'sudah dibayar':
                case 'Sudah Dibayar':
                    $status = 'Sudah Dibayar';
                    break;
                case 'belum dibayar':
                case 'Belum Dibayar':
                default:
                    $status = 'Belum Dibayar'; // fallback biar tidak null
                    break;
            }

            SpjDetail::create([
                'spj_id'            => $spj->id,
                'item'              => $item,
                'nominal'           => $request->nominal[$i],
                'status_pembayaran' => $status,
                'keterangan'        => $request->keterangan_detail[$i] ?? null,
            ]);
        }

        return redirect()->route(route: 'spj.index')->with('success', 'Data SPJ berhasil disimpan.');
    }

    public function show($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        return view('spj.show', compact('spj'));
    }

    public function edit($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        return view('spj.edit', compact('spj'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_spj'             => 'required|string|max:255',
            'no_ukd'               => 'nullable|string|max:255',
            'keterangan'           => 'nullable|string',
            'dokumen'              => 'nullable|string|max:255',
            'item.*'               => 'required|string',
            'nominal.*'            => 'required|numeric|min:0',
            'status_pembayaran.*'  => 'required|string',
            'keterangan_detail.*'  => 'nullable|string',
        ]);

        $spj = Spj::findOrFail($id);
        $spj->update([
            'nama_spj'   => $request->nama_spj,
            'no_ukd'     => $request->no_ukd,
            'keterangan' => $request->keterangan,
            'dokumen'    => $request->dokumen,
        ]);

        $spj->details()->delete();

        foreach ($request->item as $i => $item) {
            $status = strtolower(trim($request->status_pembayaran[$i] ?? ''));

            switch ($status) {
                case 'sudah dibayar':
                case 'Sudah Dibayar':
                    $status = 'Sudah Dibayar';
                    break;
                case 'belum dibayar':
                case 'Belum Dibayar':
                default:
                    $status = 'Belum Dibayar';
                    break;
            }

            SpjDetail::create([
                'spj_id'            => $spj->id,
                'item'              => $item,
                'nominal'           => $request->nominal[$i],
                'status_pembayaran' => $status,
                'keterangan'        => $request->keterangan_detail[$i] ?? null,
            ]);
        }

        return redirect()->route('spj.show', $spj->id)->with('success', 'SPJ berhasil diupdate.');
    }

    public function destroy($id)
    {
        $spj = Spj::findOrFail($id);
        $spj->details()->delete();
        $spj->delete();

        return redirect()->route('spj.index')->with('success', 'Data berhasil dihapus.');
    }
}
