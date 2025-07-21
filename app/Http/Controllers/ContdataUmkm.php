<?php

namespace App\Http\Controllers;

use App\Models\{Tahap1};
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class ContdataUmkm extends Controller
{
    /** Tampilkan data UMKM Tahap 1 */
        public function index()
        {
            $tahap1 = Tahap1::all();
            return view('umkm.proses.index', compact('tahap1'));
        }

    /** Tampilkan detail satu UMKM + relasi tahap 2–6 */
    public function show($id)
    {
        $tahap = Tahap1::with(['tahap2', 'tahap3', 'tahap4', 'tahap5', 'tahap6'])
                      ->findOrFail($id);

        return view('umkm.show', compact('tahap'));
    }

    /** Hapus data UMKM Tahap 1 */
    public function destroy($id)
    {
        $umkm = Tahap1::findOrFail($id);
        $umkm->delete();

        return redirect()->route('umkm.index')->with('success', 'Data UMKM berhasil dihapus.');
    }

    public function exportWord()
    {
        $data = Tahap1::with(['tahap2', 'tahap3', 'tahap4', 'tahap5', 'tahap6'])->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Tambah judul
        $section->addText('Data UMKM', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak(1);

        // Header kolom
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ]);

        $table->addRow();
        $headers = ['Nama', 'Produk', 'Kontak', 'Alamat', 'Jenis Usaha', 'Produksi'];
        foreach ($headers as $header) {
            $table->addCell(2000)->addText($header, ['bold' => true]);
        }

        // Data UMKM baris per baris
        foreach ($data as $d) {
            $table->addRow();

            $kontak = optional($d->tahap2)->nama_kontak_person . ' / ' . optional($d->tahap2)->No_Hp;
            $alamat = optional($d->tahap4)->alamat . ', ' . optional($d->tahap4)->kota;
            $jenisUsaha = optional($d->tahap5)->jenis_usaha;
            $produksi = optional($d->tahap6)->volume_per_tahun;

            $table->addCell(2000)->addText($d->nama_pelaku ?? '-');
            $table->addCell(2000)->addText($d->produk ?? '-');
            $table->addCell(2000)->addText($kontak ?: '-');
            $table->addCell(2000)->addText($alamat ?: '-');
            $table->addCell(2000)->addText($jenisUsaha ?: '-');
            $table->addCell(2000)->addText($produksi ?: '-');
        }

        // Simpan dan kirim file Word
        $fileName = 'data_umkm.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    

}
