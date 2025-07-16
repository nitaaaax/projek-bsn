<?php

namespace App\Http\Controllers;

use App\Models\Tahap1;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class UMKMProsesController extends Controller
{
  public function exportWord()
{
    $phpWord = new PhpWord();
    $phpWord->setDefaultFontName('Calibri');
    $phpWord->setDefaultFontSize(8);

    $section = $phpWord->addSection([
        'orientation' => 'landscape',
        'marginTop' => 400,
        'marginBottom' => 400,
        'marginLeft' => 300,
        'marginRight' => 300,
    ]);

    $section->addText('Data UMKM Proses (Belum Tersertifikasi)', [
        'bold' => true,
        'size' => 12,
    ], ['alignment' => Jc::CENTER]);

    $section->addTextBreak(1);

    $headers = [
        'No', 'Nama Pelaku Usaha', 'Produk', 'Klasifikasi', 'Status', 'Pembina I', 'Pembina II', 'Sinergi',
        'Nama Kontak', 'No HP/Telp', 'Bulan Pertama Pembinaan', 'Tahun Dibina', 'Riwayat Pembinaan', 'Gruping',
        'Email', 'Media Sosial', 'Alamat Usaha', 'Provinsi', 'Kabupaten', 'Legalitas Usaha', 'Tahun Pendirian',
        'Jenis Usaha', 'Nama Merek', 'SNI', 'LSPro', 'Omzet', 'Volume Produksi', 'Tenaga Kerja',
        'Jangkauan Pemasaran', 'Link Dokumen Mutu'
    ];

    $columnWidths = array_fill(0, count($headers), 1500);

    $phpWord->addTableStyle('CustomTableStyle', [
        'borderSize' => 6,
        'borderColor' => '888888',
        'cellMargin' => 80,
    ], ['bgColor' => 'D9D9D9']);

    $table = $section->addTable('CustomTableStyle');

    $fontHeader = ['bold' => true, 'size' => 8];
    $fontCell = ['size' => 8];
    $cellCenter = ['alignment' => Jc::CENTER];
    $cellLeft = ['alignment' => Jc::START];
    $cellRight = ['alignment' => Jc::END]; // ✅ FIX DITAMBAHIN INI

    // HEADER
    $table->addRow(600);
    foreach ($headers as $i => $header) {
        $table->addCell($columnWidths[$i], ['valign' => 'center'])->addText($header, $fontHeader, $cellCenter);
    }

    // DATA
    $data = Tahap1::where('status', '!=', 'Tersertifikasi')
        ->with(['tahap2', 'tahap3', 'tahap4', 'tahap5', 'tahap6'])
        ->get();

    $no = 1;

    foreach ($data as $row) {
        $table->addRow();

        $table->addCell(null)->addText($no++, $fontCell, $cellCenter);
        $table->addCell(null)->addText($row->nama_pelaku ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText($row->produk ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText($row->klasifikasi ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText($row->status ?? '-', $fontCell, $cellCenter);
        $table->addCell(null)->addText($row->pembina_1 ?? '-', $fontCell, $cellLeft);

        // Tahap2
        $table->addCell(null)->addText(optional($row->tahap2)->pembina_2 ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap2)->sinergi ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap2)->nama_kontak_person ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap2)->no_hp ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap2)->bulan_pertama_pembinaan ?? '-', $fontCell, $cellLeft);

        // Tahap3
        $table->addCell(null)->addText(optional($row->tahap3)->tahun_dibina ?? '-', $fontCell, $cellCenter);
        $table->addCell(null)->addText(optional($row->tahap3)->riwayat ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap3)->gruping ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap3)->email ?? '-', $fontCell, $cellLeft);

        // Tahap5
        $table->addCell(null)->addText(optional($row->tahap5)->sosial_media ?? '-', $fontCell, $cellLeft);

        // Tahap4
        $table->addCell(null)->addText(optional($row->tahap4)->alamat ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap4)->provinsi ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap4)->kota ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap4)->legalitas_usaha ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap4)->tahun_pendirian ?? '-', $fontCell, $cellCenter);

        // Tahap5
        $table->addCell(null)->addText(optional($row->tahap5)->jenis_usaha ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap5)->nama_merek ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap5)->sni ?? '-', $fontCell, $cellCenter);
        $table->addCell(null)->addText(optional($row->tahap5)->lspro ?? '-', $fontCell, $cellCenter);

        // Tahap6
        $table->addCell(null)->addText(optional($row->tahap6)->omzet ?? '-', $fontCell, $cellRight);
        $table->addCell(null)->addText(optional($row->tahap6)->volume_per_tahun ?? '-', $fontCell, $cellRight);
        $table->addCell(null)->addText(optional($row->tahap6)->jumlah_tenaga_kerja ?? '-', $fontCell, $cellCenter);
        $table->addCell(null)->addText(optional($row->tahap6)->jangkauan_pemasaran ?? '-', $fontCell, $cellLeft);
        $table->addCell(null)->addText(optional($row->tahap6)->dokumen_mutu ?? '-', $fontCell, $cellLeft);
    }

    $filename = 'UMKM_Proses_Lengkap.docx';
    $tempFile = tempnam(sys_get_temp_dir(), 'word');
    IOFactory::createWriter($phpWord, 'Word2007')->save($tempFile);

    return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
}


    public function index()
    {
        $data = Tahap1::where('status', '!=', 'Tersertifikasi')
            ->with(['tahap2', 'tahap3', 'tahap4', 'tahap5', 'tahap6'])
            ->get();

        return view('umkm.proses.index', compact('data'));
    }

    public function sertifikasi($id)
    {
        $umkm = Tahap1::findOrFail($id);
        $umkm->status = 'Tersertifikasi';
        $umkm->save();

        return redirect()->route('umkm.proses.index')->with('success', 'UMKM berhasil disertifikasi!');
    }

    public function destroy($id)
    {
        $umkm = Tahap1::findOrFail($id);
        $umkm->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
