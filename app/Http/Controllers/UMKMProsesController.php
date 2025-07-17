<?php

namespace App\Http\Controllers;

use App\Models\{Tahap1, Tahap2, Tahap3, Tahap4, Tahap5, Tahap6};
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UmkmExport;
use App\Imports\UmkmImport;

class UMKMProsesController extends Controller
{
    public function index()
    {
        $tahap1 = Tahap1::where('status', '!=', 'Tersertifikasi')->get();
        return view('umkm.proses.index', compact('tahap1'));
    }

    public function sertifikasi($id)
    {
        $umkm = Tahap1::findOrFail($id);
        $umkm->status = 'Tersertifikasi';
        $umkm->save();

        return redirect()->route('umkm.proses.index')->with('success', 'UMKM berhasil disertifikasi!');
    }


        public function export()
    {
        return Excel::download(new UmkmExport, 'data_umkm.xlsx');
    }

    public function exportWord()
    {
        $phpWord = new PhpWord();

        // Buat Section Word
        $section = $phpWord->addSection();

        // Ambil semua data UMKM
        $tahap1s = Tahap1::all();

        foreach ($tahap1s as $tahap1) {
            $tahap2 = $tahap1->tahap2;
            $tahap3 = $tahap1->tahap3;
            $tahap4 = $tahap1->tahap4;
            $tahap5 = $tahap1->tahap5;
            $tahap6 = $tahap1->tahap6;

            $section->addText("Nama Pelaku Usaha: " . $tahap1->nama_pelaku);
            $section->addText("Produk: " . $tahap1->produk);
            $section->addText("Klasifikasi: " . $tahap1->klasifikasi);
            $section->addText("Status: " . $tahap1->status);
            $section->addText("Pembina 1: " . $tahap1->pembina_1);
            $section->addText("Pembina 2: " . optional($tahap2)->pembina_2);
            $section->addText("Alamat: " . optional($tahap4)->alamat_pemilik);
            $section->addText("Email: " . optional($tahap4)->email);
            $section->addText("No HP: " . optional($tahap2)->No_Hp);
            $section->addText("Legalitas: " . optional($tahap4)->legalitas);
            $section->addTextBreak(1); // Tambah spasi
        }

        // Simpan file Word sementara
        $filename = 'Data-UMKM-' . now()->format('YmdHis') . '.docx';
        $tempPath = storage_path($filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);

        // Kembalikan sebagai download
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }


    /** Import data UMKM dari Excel (xlsx/xls/csv) */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new UmkmImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data berhasil diimpor!');
    }
}
