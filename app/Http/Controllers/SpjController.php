<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\SpjDetail;
use Illuminate\Http\Request;
use App\Exports\SpjExport;
use App\Imports\SpjImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

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
            'ls'                  => 'nullable|string',
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
            'ls'         => $request->ls,
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
            'ls'                   => 'nullable|string',
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

        return redirect()->route('admin.spj.show', $spj->id)->with('success', 'SPJ berhasil diupdate.');
    }

    public function destroy($id)
    {
        $spj = Spj::findOrFail($id);
        $spj->details()->delete();
        $spj->delete();

        return redirect()->route('spj.index')->with('success', 'Data berhasil dihapus.');
    }
public function downloadWord($id)
{
    $spj = Spj::with('details')->findOrFail($id);

    $templatePath = public_path('template/template_ekspor_spj.docx');
    if (!file_exists($templatePath)) {
        abort(404, 'Template Word tidak ditemukan di: ' . $templatePath);
    }

    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

    // Fungsi konversi angka ke terbilang
    function angkaToTerbilang($angka) {
        $angka = (float)$angka;
        $bilangan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        
        if ($angka < 12) {
            return $bilangan[$angka];
        } elseif ($angka < 20) {
            return $bilangan[$angka - 10] . ' belas';
        } elseif ($angka < 100) {
            return $bilangan[(int)($angka / 10)] . ' puluh ' . $bilangan[$angka % 10];
        } elseif ($angka < 200) {
            return 'seratus ' . angkaToTerbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $bilangan[(int)($angka / 100)] . ' ratus ' . angkaToTerbilang($angka % 100);
        } elseif ($angka < 2000) {
            return 'seribu ' . angkaToTerbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return angkaToTerbilang((int)($angka / 1000)) . ' ribu ' . angkaToTerbilang($angka % 1000);
        }
        
        return 'Angka terlalu besar';
    }

    // Data umum
    $templateProcessor->setValue('No_UKD', $spj->no_ukd ?? '-');
    $templateProcessor->setValue('nominal', number_format($spj->details->sum('nominal') ?? 0, 0, ',', '.'));
    $templateProcessor->setValue('item', ($spj->details->first()->item ?? '-') . ' dalam rangka Penguatan Penerapan Standardisasi dan Penilaian Kesesuaian');
    $templateProcessor->setValue('tanggal_ekspor', now()->format('d F Y'));
    
    // Konversi nominal ke terbilang
    $totalNominal = $spj->details->sum('nominal') ?? 0;
    $terbilang = angkaToTerbilang($totalNominal) . ' rupiah';
    $templateProcessor->setValue('terbilang', $terbilang);

    $fileName = 'SPJ_' . $spj->no_ukd . '_' . now()->format('YmdHis') . '.docx';
    $savePath = storage_path('app/public/' . $fileName);
    $templateProcessor->saveAs($savePath);

    return response()->download($savePath)->deleteFileAfterSend(true);
}


private function terbilang($number)
{
    $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($number == 0) {
        return "nol";
    } elseif ($number < 12) {
        return $angka[$number];
    } elseif ($number < 20) {
        return $this->terbilang($number - 10) . " belas";
    } elseif ($number < 100) {
        return $this->terbilang(floor($number / 10)) . " puluh " . $this->terbilang($number % 10);
    } elseif ($number < 200) {
        return "seratus " . $this->terbilang($number - 100);
    } elseif ($number < 1000) {
        return $this->terbilang(floor($number / 100)) . " ratus " . $this->terbilang($number % 100);
    } elseif ($number < 2000) {
        return "seribu " . $this->terbilang($number - 1000);
    } elseif ($number < 1000000) {
        return $this->terbilang(floor($number / 1000)) . " ribu " . $this->terbilang($number % 1000);
    } elseif ($number < 1000000000) {
        return $this->terbilang(floor($number / 1000000)) . " juta " . $this->terbilang($number % 1000000);
    } else {
        return $this->terbilang(floor($number / 1000000000)) . " miliar " . $this->terbilang($number % 1000000000);
    }
}


}
