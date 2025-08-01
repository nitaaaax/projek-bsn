<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor;
    use Maatwebsite\Excel\Facades\Excel;
    use App\Imports\UmkmImport;
    use App\Models\Tahap1;
    use App\Models\Tahap2;
    use ZipArchive;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;

    class UmkmExportImportController extends Controller
    {

    public function exportWord($id)
    {
        $item = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::where('pelaku_usaha_id', $item->id)->first();

        $templatePath = public_path('template/template_eksporumkm.docx');
        $exportPath = storage_path('app/public/exports');

        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        $template = new TemplateProcessor($templatePath);

        // Data Tahap1
        $template->setValue('nama_umk', $item->nama_pelaku ?? '-');
        $template->setValue('nama_kontak_person', $item->nama_kontak_person ?? '-');
        $template->setValue('no_hp', $item->no_hp ?? '-');
        $template->setValue('email', $item->email ?? '-');
        $template->setValue('media_sosial', $item->media_sosial ?? '-');
        $template->setValue('produk', $item->produk ?? '-');
        $template->setValue('nama_merek', $item->nama_merek ?? '-');

        // Data Tahap2
        $template->setValue('alamat_kantor', $tahap2->alamat_kantor ?? '-');
        $template->setValue('provinsi_kantor', $tahap2->provinsi_kantor ?? '-');
        $template->setValue('kota_kantor', $tahap2->kota_kantor ?? '-');
        $template->setValue('alamat_pabrik', $tahap2->alamat_pabrik ?? '-');
        $template->setValue('provinsi_pabrik', $tahap2->provinsi_pabrik ?? '-');
        $template->setValue('kota_pabrik', $tahap2->kota_pabrik ?? '-');
        $template->setValue('legalitas_usaha', $tahap2->legalitas_usaha ?? '-');
        $template->setValue('tahun_pendirian', $tahap2->tahun_pendirian ?? '-');
        $template->setValue('jenis_usaha', $tahap2->jenis_usaha ?? '-');
        $template->setValue('tanda_daftar_merk', $tahap2->tanda_daftar_merk ?? '-');
        $template->setValue('sni', $tahap2->sni_yang_akan_diterapkan ?? '-');
        $template->setValue('omzet', $tahap2->omzet ?? '-');
        $template->setValue('volume_per_tahun', $tahap2->volume_per_tahun ?? '-');
        $template->setValue('jumlah_tenaga_kerja', $tahap2->jumlah_tenaga_kerja ?? '-');
        $template->setValue('sertifikat', $tahap2->sertifikat ?? '-');
        $template->setValue('jangkauan_pemasaran', $tahap2->jangkauan_pemasaran ?? '-');
        $template->setValue('instansi', $tahap2->instansi ?? '-');


        $template->setValue('tanggal_export', Carbon::now()->format('d-m-Y'));

        $filename = 'UMKM_' . preg_replace('/[^A-Za-z0-9]/', '_', $item->nama_pelaku). '.docx';
        $filePath = $exportPath . '/' . $filename;
        $template->saveAs($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

        public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new UmkmImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimport!');
    }

    }
