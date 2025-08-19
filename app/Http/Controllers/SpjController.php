<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\SpjDetail;
use Illuminate\Http\Request;
use App\Exports\SpjExport;
use App\Imports\SpjImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class SpjController extends Controller
{
    public function index()
    {
        $spj = Spj::with('details')->get();
        $user = auth()->user();

        $sudahBayar = SpjDetail::with('spj')
            ->where('status_pembayaran', 'Sudah Dibayar')->get();

        $belumBayar = SpjDetail::with('spj')
            ->where('status_pembayaran', 'Belum Dibayar')->get();

        return view('spj.index', compact('spj', 'sudahBayar', 'belumBayar','user'));
    }

    public function export()
    {
        $user = Auth::user();

        // Cek role: hanya admin & user yang diizinkan
        if (!in_array(optional($user->role)->name, ['admin', 'user'])) {
            abort(403, 'Anda tidak memiliki akses untuk export data SPJ.');
        }

        return Excel::download(new SpjExport, 'spj_cair.xlsx');
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120' // 5MB max size
        ]);

        DB::beginTransaction();

        try {
            // Execute the import
            Excel::import(new SpjImport, $request->file('file'));
            
            DB::commit();

            return redirect()->back()->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Import Berhasil',
                    'message' => 'Data SPJ berhasil diimpor!'
                ]
            ]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();
            
            // Compile validation error messages
            $errorMessages = [];
            foreach ($e->failures() as $failure) {
                $errorMessages[] = sprintf(
                    "Baris %s: %s (Kolom: %s, Nilai: %s)",
                    $failure->row(),
                    $failure->errors()[0],
                    $failure->attribute(),
                    json_encode($failure->values())
                );
            }

            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Validasi Gagal',
                    'message' => 'Terdapat kesalahan dalam data'
                ],
                'import_errors' => $errorMessages
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'File Tidak Valid',
                    'message' => $e->getMessage()
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Error Sistem',
                    'message' => 'Gagal mengimpor data: ' . $e->getMessage()
                ]
            ]);
        }
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
            'lembaga_sertifikasi'  => 'nullable|string',
            'keterangan'           => 'nullable|string',
            'dokumen'              => 'nullable|string|max:255',
            'item.*'               => 'required|string',
            'nominal.*'            => 'required|numeric|min:0',
            'status_pembayaran.*'  => 'required|string',
            'keterangan_detail.*'  => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $spj = Spj::create([
                'nama_spj'             => $request->nama_spj,
                'no_ukd'               => $request->no_ukd,
                'lembaga_sertifikasi'  => $request->lembaga_sertifikasi,
                'keterangan'           => $request->keterangan,
                'dokumen'              => $request->dokumen,
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

            DB::commit();

            return redirect()->route('spj.index')->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Data SPJ berhasil disimpan'
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
            'nama_spj'               => 'required|string|max:255',
            'no_ukd'                 => 'nullable|string|max:255',
            'lembaga_sertifikasi'    => 'nullable|string',
            'keterangan'             => 'nullable|string',
            'dokumen'                => 'nullable|string|max:255',
            'item.*'                 => 'required|string',
            'nominal.*'              => 'required|numeric|min:0',
            'status_pembayaran.*'    => 'required|string',
            'keterangan_detail.*'    => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $spj = Spj::findOrFail($id);
            $spj->update([
                'nama_spj'   => $request->nama_spj,
                'no_ukd'     => $request->no_ukd,
                'lembaga_sertifikasi'   => $request->lembaga_sertifikasi,
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
                    'keterangan'        => $request->keterangan_detail[$i] ?? $request->keterangan,       
                ]);
            }

            DB::commit();

            return redirect()->route('admin.spj.show', $spj->id)->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'SPJ berhasil diperbarui'
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

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $spj = Spj::findOrFail($id);
            $spj->details()->delete();
            $spj->delete();

            DB::commit();

            return redirect()->route('spj.index')->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Data SPJ berhasil dihapus'
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
