<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\Tahap1;
use App\Models\Tahap2;
use Carbon\Carbon;

class UmkmExportImportController extends Controller
{
    public function exportWord()
    {
        $data = Tahap1::all();
        $templatePath = public_path('template/template_eksporumkm.docx');
        $exportDir = storage_path('app/public/ekspor');

        if (!file_exists($exportDir)) {
            mkdir($exportDir, 0777, true);
        }

        foreach ($data as $item) {
            $tahap2 = Tahap2::where('pelaku_usaha_id', $item->id)->first();

            if (!$tahap2) {
                continue; 
            }

            try {
                $template = new TemplateProcessor($templatePath);
            } catch (\Exception $e) {
                return 'Gagal membuka template: ' . $e->getMessage();
            }

            // Set value sesuai template Word
            $template->setValue('nama_umk', $item->nama_pelaku ?? '-');
            $template->setValue('nama_kontak_person', $item->nama_kontak_person ?? '-');
            $template->setValue('no_hp', $item->no_hp ?? '-');
            $template->setValue('email', $item->email ?? '-');
            $template->setValue('media_sosial', $item->media_sosial ?? '-');

            $template->setValue('alamat_kantor', $tahap2->alamat_kantor ?? '-');
            $template->setValue('provinsi_kantor', $tahap2->provinsi_kantor ?? '-');
            $template->setValue('kota_kantor', $tahap2->kota_kantor ?? '-');

            $template->setValue('alamat_pabrik', $tahap2->alamat_pabrik ?? '-');
            $template->setValue('provinsi_pabrik', $tahap2->provinsi_pabrik ?? '-');
            $template->setValue('kota_pabrik', $tahap2->kota_pabrik ?? '-');

            $template->setValue('legalitas_usaha', $tahap2->legalitas_usaha ?? '-');
            $template->setValue('tahun_pendirian', $tahap2->tahun_pendirian ?? '-');
            $template->setValue('jenis_usaha', $tahap2->jenis_usaha ?? '-');
            $template->setValue('produk', $item->produk ?? '-');
            $template->setValue('nama_merek', $item->nama_merek ?? '-');
            $template->setValue('tanda_daftar_merek', $tahap2->tanda_daftar_merek ?? '-');
            $template->setValue('sni', $tahap2->sni_yang_akan_diterapkan ?? '-');
            $template->setValue('omzet', $tahap2->omzet ?? '-');
            $template->setValue('volume_per_tahun', $tahap2->volume_per_tahun ?? '-');
            $template->setValue('jumlah_tenaga_kerja', $tahap2->jumlah_tenaga_kerja ?? '-');
            $template->setValue('sertifikat', $tahap2->sertifikat ?? '-');

            // Handle jangkauan pemasaran
            $jangkauan = is_string($tahap2->jangkauan_pemasaran)
                ? implode(', ', json_decode($tahap2->jangkauan_pemasaran, true))
                : '-';
            $template->setValue('jangkauan_pemasaran', $jangkauan);

            // Instansi pembina
            $template->setValue('instansi', $item->instansi ?? '-');

            //Tanggal download
            $tanggalFormat = Carbon::now()->translatedFormat('d F Y');
            $template->setValue('tanggal_export', $tanggalFormat);

            // Simpan hasil export
            $filename = 'UMKM_' . preg_replace('/\s+/', '_', $item->nama_pelaku) . '.docx';
            $savePath = $exportDir . '/' . $filename;
            $template->saveAs($savePath);
        }

        return response()->download($savePath)->deleteFileAfterSend(true);
    }
}
