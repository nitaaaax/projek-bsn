<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kota;
use Illuminate\Support\Facades\DB;


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
        DB::beginTransaction();

        try {
            // Case 1: Only province input
            if ($request->filled('nama_provinsi') && !$request->filled('nama_kota')) {
                $request->validate([
                    'nama_provinsi' => 'required|string|max:255',
                ]);

                Provinsi::create([
                    'nama' => $request->nama_provinsi
                ]);

                DB::commit();

                return redirect()->back()->with([
                    'toastr' => [
                        'type' => 'success',
                        'title' => 'Berhasil',
                        'message' => 'Provinsi berhasil ditambahkan'
                    ]
                ]);
            }

            // Case 2: Only city input
            if ($request->filled('nama_kota') && $request->filled('provinsi_id')) {
                $request->validate([
                    'nama_kota' => 'required|string|max:255',
                    'provinsi_id' => 'required|exists:provinsis,id'
                ]);

                Kota::create([
                    'nama' => $request->nama_kota,
                    'provinsi_id' => $request->provinsi_id
                ]);

                DB::commit();

                return redirect()->back()->with([
                    'toastr' => [
                        'type' => 'success',
                        'title' => 'Berhasil',
                        'message' => 'Kota berhasil ditambahkan'
                    ]
                ]);
            }

            // Case 3: Invalid input
            DB::rollBack();
            return redirect()->back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Peringatan',
                    'message' => 'Silakan isi salah satu data: Provinsi atau Kota'
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with([
                    'toastr' => [
                        'type' => 'error',
                        'title' => 'Validasi Gagal',
                        'message' => 'Terdapat kesalahan dalam input data'
                    ]
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]
            ]);
        }
    }

    public function destroy($id, Request $request)
    {
        DB::beginTransaction();

        try {
            $type = $request->input('type');

            if ($type === 'kota') {
                $kota = Kota::findOrFail($id);
                $kota->delete();
                
                DB::commit();
                
                return redirect()->back()->with([
                    'toastr' => [
                        'type' => 'success',
                        'title' => 'Berhasil',
                        'message' => 'Kota berhasil dihapus'
                    ]
                ]);
            } else {
                $provinsi = Provinsi::findOrFail($id);
                $provinsi->delete();
                
                DB::commit();
                
                return redirect()->back()->with([
                    'toastr' => [
                        'type' => 'success',
                        'title' => 'Berhasil',
                        'message' => 'Provinsi berhasil dihapus'
                    ]
                ]);
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Data Tidak Ditemukan',
                    'message' => 'Data yang akan dihapus tidak ditemukan'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ]
            ]);
        }
    }

}
