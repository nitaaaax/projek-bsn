<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Models\Tahap1;
use App\Models\Tahap2;
use App\Models\Tahap3;
use App\Models\Tahap4;
use App\Models\Tahap5;
use App\Models\Tahap6;

class UmkmExportImportController extends Controller
{

public function exportWord()
{
    $data = Tahap1::all();

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Judul Utama
    $section->addTitle('Laporan Data UMKM', 1);
    $section->addTextBreak(1);

    // Style Tabel
    $tableStyle = [
        'borderSize' => 6,
        'borderColor' => '000000',
        'cellMargin' => 50
    ];
    $firstRowStyle = ['bgColor' => 'DDDDDD']; // Warna header
    $phpWord->addTableStyle('Data UMKM', $tableStyle, $firstRowStyle);

    foreach ($data as $item) {
        $pembinaan = Tahap2::where('pelaku_usaha_id', $item->id)->first();
        $riwayat   = Tahap3::where('pelaku_usaha_id', $item->id)->first();
        $alamat    = Tahap4::where('pelaku_usaha_id', $item->id)->first();
        $usaha     = Tahap5::where('pelaku_usaha_id', $item->id)->first();
        $produksi  = Tahap6::where('pelaku_usaha_id', $item->id)->first();

        // Judul UMKM
        $section->addText('UMKM: ' . $item->nama_pelaku, ['bold' => true, 'size' => 14]);
        $section->addTextBreak(0.5);

        // Tabel untuk data UMKM
        $table = $section->addTable('Data UMKM');

        // Tambahkan Header Tabel
        $table->addRow();
        $table->addCell(4000)->addText('Field', ['bold' => true]);
        $table->addCell(8000)->addText('Value', ['bold' => true]);

        // Tahap 1
        $table->addRow();
        $table->addCell()->addText('Nama Pelaku');
        $table->addCell()->addText($item->nama_pelaku);

        $table->addRow();
        $table->addCell()->addText('Produk');
        $table->addCell()->addText($item->produk);

        $table->addRow();
        $table->addCell()->addText('Klasifikasi');
        $table->addCell()->addText($item->klasifikasi);

        $table->addRow();
        $table->addCell()->addText('Status');
        $table->addCell()->addText($item->status);

        $table->addRow();
        $table->addCell()->addText('Pembina 1');
        $table->addCell()->addText($item->pembina_1);

        // Tahap 2
        if ($pembinaan) {
            $table->addRow();
            $table->addCell()->addText('Pembina 2');
            $table->addCell()->addText($pembinaan->pembina_2);

            $table->addRow();
            $table->addCell()->addText('Sinergi');
            $table->addCell()->addText($pembinaan->sinergi);

            $table->addRow();
            $table->addCell()->addText('Kontak Person');
            $table->addCell()->addText($pembinaan->nama_kontak_person);

            $table->addRow();
            $table->addCell()->addText('No HP');
            $table->addCell()->addText($pembinaan->No_Hp);

            $table->addRow();
            $table->addCell()->addText('Bulan Pembinaan');
            $table->addCell()->addText($pembinaan->bulan_pertama_pembinaan);
        }

        // Tahap 3
        if ($riwayat) {
            $table->addRow();
            $table->addCell()->addText('Tahun Dibina');
            $table->addCell()->addText($riwayat->tahun_dibina);

            $table->addRow();
            $table->addCell()->addText('Riwayat Pembinaan');
            $table->addCell()->addText($riwayat->riwayat_pembinaan);

            $table->addRow();
            $table->addCell()->addText('Status Pembinaan');
            $table->addCell()->addText($riwayat->status_pembinaan);

            $table->addRow();
            $table->addCell()->addText('Email');
            $table->addCell()->addText($riwayat->email);

            $table->addRow();
            $table->addCell()->addText('Media Sosial');
            $table->addCell()->addText($riwayat->media_sosial);
        }

        // Tahap 4
        if ($alamat) {
            $table->addRow();
            $table->addCell()->addText('Alamat');
            $table->addCell()->addText($alamat->alamat);

            $table->addRow();
            $table->addCell()->addText('Provinsi');
            $table->addCell()->addText($alamat->provinsi);

            $table->addRow();
            $table->addCell()->addText('Kota');
            $table->addCell()->addText($alamat->kota);

            $table->addRow();
            $table->addCell()->addText('Legalitas Usaha');
            $table->addCell()->addText($alamat->legalitas_usaha);

            $table->addRow();
            $table->addCell()->addText('Tahun Pendirian');
            $table->addCell()->addText($alamat->tahun_pendirian);
        }

        // Tahap 5
        if ($usaha) {
            $table->addRow();
            $table->addCell()->addText('Jenis Usaha');
            $table->addCell()->addText($usaha->jenis_usaha);

            $table->addRow();
            $table->addCell()->addText('Nama Merek');
            $table->addCell()->addText($usaha->nama_merek);

            $table->addRow();
            $table->addCell()->addText('SNI');
            $table->addCell()->addText($usaha->sni);

            $table->addRow();
            $table->addCell()->addText('LSPRO');
            $table->addCell()->addText($usaha->lspro);
        }

        // Tahap 6
        if ($produksi) {
            $table->addRow();
            $table->addCell()->addText('Omzet');
            $table->addCell()->addText($produksi->omzet);

            $table->addRow();
            $table->addCell()->addText('Volume per Tahun');
            $table->addCell()->addText($produksi->volume_per_tahun);

            $table->addRow();
            $table->addCell()->addText('Jumlah Tenaga Kerja');
            $table->addCell()->addText($produksi->jumlah_tenaga_kerja);

            $table->addRow();
            $table->addCell()->addText('Jangkauan Pemasaran');
            $table->addCell()->addText($produksi->jangkauan_pemasaran);

            $table->addRow();
            $table->addCell()->addText('Link Dokumen');
            $table->addCell()->addText($produksi->link_dokumen);
        }

        $section->addTextBreak(1); // Spasi antar UMKM
    }

    $fileName = 'data_umkm.docx';
    $tempFile = tempnam(sys_get_temp_dir(), 'umkm_') . '.docx';
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($tempFile);

    return response()->download($tempFile)->deleteFileAfterSend(true);
}

}
