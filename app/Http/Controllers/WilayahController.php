<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kota;

class WilayahController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->input('search');

        // Query untuk provinsi
        $provinsis = Provinsi::with('kotas')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->get();

        // Query untuk kota
        $kotas = Kota::with('provinsi')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhereHas('provinsi', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        return view('admin.wilayah.index', compact('provinsis', 'kotas', 'search'));
    }

    public function store(Request $request)
    {
        // Kalau input provinsi saja
        if ($request->filled('nama_provinsi') && !$request->filled('nama_kota')) {
            $request->validate([
                'nama_provinsi' => 'required|string|max:255',
            ]);

            Provinsi::create([
                'nama' => $request->nama_provinsi
            ]);

            return redirect()->back()->with('success', 'Provinsi berhasil ditambahkan.');
        }

        // Kalau input kota saja
        if ($request->filled('nama_kota') && $request->filled('provinsi_id')) {
            $request->validate([
                'nama_kota' => 'required|string|max:255',
                'provinsi_id' => 'required|exists:provinsis,id'
            ]);

            Kota::create([
                'nama' => $request->nama_kota,
                'provinsi_id' => $request->provinsi_id
            ]);

            return redirect()->back()->with('success', 'Kota berhasil ditambahkan.');
        }

        // Kalau dua-duanya kosong atau inputan tidak lengkap
        return redirect()->back()->with('error', 'Silakan isi salah satu data: Provinsi atau Kota.');
    }

    public function destroy($id, Request $request)
    {
        $type = $request->input('type');

        if ($type === 'kota') {
            $kota = Kota::findOrFail($id);
            $kota->delete();
            return redirect()->back()->with('success', 'Kota berhasil dihapus.');
        } else {
            $provinsi = Provinsi::findOrFail($id);
            $provinsi->delete();
            return redirect()->back()->with('success', 'Provinsi berhasil dihapus.');
        }
    }
}
