<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\SpjDetail;
use Illuminate\Http\Request;
use App\Exports\SpjExport;
use App\Imports\SpjImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Element\TextRun;
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
        //dd($request->all());

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

        $spj = Spj::create([
            'nama_spj'             => $request->nama_spj,
            'no_ukd'               => $request->no_ukd,
            'lembaga_sertifikasi'  => $request->lembaga_sertifikasi, // perbaiki typo di sini
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

        return redirect()->route('spj.index')->with('success', 'Data SPJ berhasil disimpan.');
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
        //dd($request->all());

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


    public function downloadWord($detailId)
    {
        $detail = SpjDetail::with('spj')->findOrFail($detailId);
        $spj = $detail->spj;

        $templatePath = public_path('template/template_ekspor_spj.docx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template Word tidak ditemukan di: ' . $templatePath);
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // Fungsi angka ke terbilang
        $angkaToTerbilang = function($angka) use (&$angkaToTerbilang) {
            $angka = (int)$angka;
            $bilangan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
            if ($angka == 0) return '';
            elseif ($angka < 12) return $bilangan[$angka];
            elseif ($angka < 20) return $angkaToTerbilang($angka - 10) . ' belas';
            elseif ($angka < 100) return trim($angkaToTerbilang(intval($angka / 10)) . ' puluh ' . $angkaToTerbilang($angka % 10));
            elseif ($angka < 200) return 'seratus ' . $angkaToTerbilang($angka - 100);
            elseif ($angka < 1000) return trim($angkaToTerbilang(intval($angka / 100)) . ' ratus ' . $angkaToTerbilang($angka % 100));
            elseif ($angka < 2000) return 'seribu ' . $angkaToTerbilang($angka - 1000);
            elseif ($angka < 1000000) return trim($angkaToTerbilang(intval($angka / 1000)) . ' ribu ' . $angkaToTerbilang($angka % 1000));
            elseif ($angka < 1000000000) return trim($angkaToTerbilang(intval($angka / 1000000)) . ' juta ' . $angkaToTerbilang($angka % 1000000));
            else return 'angka terlalu besar';
        };

        // Format nominal & bold
        $nominal = $detail->nominal ?? 0;
        $formattedNominal = 'Rp. ' . number_format($nominal, 0, ',', '.');
        $nominalTextRun = new TextRun();
        $nominalTextRun->addText($formattedNominal, ['bold' => true]);

        // Terbilang
        $terbilang = ucfirst(strtolower(trim($angkaToTerbilang($nominal)))) . ' rupiah';

        // Set value ke template
        $templateProcessor->setValue('No_UKD', $spj->no_ukd ?? '-');
        $templateProcessor->setValue('item', $detail->item ?? '-');
        $templateProcessor->setComplexValue('nominal', $nominalTextRun);
        $templateProcessor->setValue('terbilang_nominal', '= ' . $terbilang . ' =');
        $templateProcessor->setValue('lembaga_sertifikasi', $spj->lembaga_sertifikasi ?? '-');

        // Tanggal
        $bulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        $tanggalSekarang = now();
        $templateProcessor->setValue('tanggal_ekspor', $tanggalSekarang->day . ' ' . $bulan[(int)$tanggalSekarang->month] . ' ' . $tanggalSekarang->year);

        // Nama file
        $fileName = 'Kuitansi_Item_' . $detail->id . '.docx';
        $savePath = storage_path('app/public/' . $fileName);

        $templateProcessor->saveAs($savePath);

        return response()->download($savePath)->deleteFileAfterSend(true);
    }





}
