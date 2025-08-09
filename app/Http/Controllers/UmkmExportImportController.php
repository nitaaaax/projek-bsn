<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor;
    use Maatwebsite\Excel\Facades\Excel;
    use App\Imports\UmkmImport;
    use App\Models\Tahap1;
    use App\Models\Tahap2;
    use PhpOffice\PhpWord\Shared\Html;
    use ZipArchive;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;

    class UmkmExportImportController extends Controller
    {

    public function exportWord($id)
    {
        $item = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::with(['provinsiKantor', 'kotaKantor', 'provinsiPabrik', 'kotaPabrik'])
            ->where('pelaku_usaha_id', $item->id)
            ->first();

        if (!$tahap2) {
            abort(404, 'Data Tahap 2 tidak ditemukan.');
        }

        $templatePath = public_path('template/template_eksporumkm.docx');
        $exportPath = storage_path('app/public/exports');

        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        $template = new TemplateProcessor($templatePath);

        // --- Jangkauan Pemasaran ---
        $jangkauanRaw = $tahap2->jangkauan_pemasaran ?? '{}';
        $jangkauanArr = [];
        $decoded = json_decode($jangkauanRaw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $jangkauanArr = $decoded;
        }

        $jangkauanKeys = ['Local', 'Nasional', 'Internasional', 'Lainnya'];
        $jangkauanLabels = ['a. Local', 'b. Nasional', 'c. Internasional', 'd. Lainnya'];
        $jangkauanFormatted = '';

        foreach ($jangkauanKeys as $index => $key) {
            $value = $jangkauanArr[$key] ?? null;
            $jangkauanFormatted .= $jangkauanLabels[$index] . "\n" .
                (!empty(trim($value ?? '')) ? $value : '-') . "\n\n";
        }

        // --- Instansi ---
        $instansiRaw = $tahap2->instansi ?? '{}';
        $instansiArr = [];
        $decoded = json_decode($instansiRaw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $instansiArr = $decoded;
        }
        $instansiKeys = ['Dinas', 'Kementerian', 'Perguruan Tinggi', 'Komunitas', 'Lainnya'];
        $instansiLabels = ['a. Dinas', 'b. Kementerian', 'c. Perguruan Tinggi', 'd. Komunitas', 'e. Lainnya'];
        $instansiFormatted = '';
        foreach ($instansiKeys as $index => $key) {
            $value = $instansiArr[$key] ?? null;
            $instansiFormatted .= $instansiLabels[$index] . "\n" .
                (trim($value) !== '' ? $value : '-') . "\n\n";
        }

        // --- Legalitas Usaha ---
        $legalitasList = [
            'nib' => 'a) NIB',
            'iumk' => 'b) IUMK',
            'siup' => 'c) SIUP',
            'tdp' => 'd) TDP',
            'npwp pemilik' => 'e) NPWP Pemilik',
            'npwp badan usaha' => 'f) NPWP Badan Usaha',
            'akta pendirian usaha' => 'g) Akta Pendirian Usaha',
        ];

        $legalitasRaw = json_decode($tahap2->legalitas_usaha ?? '[]', true) ?: [];
        $legalitasNormalized = array_map(function ($item) {
            return strtolower(trim($item));
        }, $legalitasRaw);
        $legalitasKeys = array_map('strtolower', array_keys($legalitasList));

        $legalitasFormatted = '';
        foreach ($legalitasList as $key => $label) {
            $tersedia = in_array(strtolower($key), $legalitasNormalized) ? 'Tersedia' : '-';
            $legalitasFormatted .= "$label : $tersedia\n\n";
        }

        // Ambil isi "Lainnya" yang bukan checkbox standar
        $lainnyaIsi = null;
        foreach ($legalitasNormalized as $itemLainnya) {
            if (!in_array($itemLainnya, $legalitasKeys)) {
                $lainnyaIsi = $itemLainnya;
                break;
            }
        }
        $legalitasFormatted .= "h) Lainnya : " . ($lainnyaIsi ? ucfirst($lainnyaIsi) : '-') . "\n\n";

        // --- Sertifikat ---
        $sertifikatList = [
            'pirt' => 'a) PIRT',
            'md' => 'b) MD',
            'halal' => 'c) Halal',
        ];

        $sertifikatDataRaw = json_decode($tahap2->sertifikat ?? '[]', true) ?: [];
        $sertifikatNormalized = array_map(function ($item) {
            return strtolower(trim($item));
        }, $sertifikatDataRaw);
        $sertifikatKeys = array_map('strtolower', array_keys($sertifikatList));

        $sertifikatFormatted = '';
        foreach ($sertifikatList as $key => $label) {
            $tersedia = in_array(strtolower($key), $sertifikatNormalized) ? 'Tersedia' : '-';
            $sertifikatFormatted .= "$label : $tersedia\n\n";
        }

        // Ambil isi "Lainnya" yang bukan checkbox standar
        $sertLainnyaIsi = null;
        foreach ($sertifikatNormalized as $itemLainnya) {
            if (!in_array($itemLainnya, $sertifikatKeys)) {
                $sertLainnyaIsi = $itemLainnya;
                break;
            }
        }
        $sertifikatFormatted .= "d) Lainnya : " . ($sertLainnyaIsi ? ucfirst($sertLainnyaIsi) : '-') . "\n\n";

        // --- Foto Produk dan Tempat Produksi ---
        $foto_produk = json_decode($tahap2->foto_produk ?? '[]', true) ?: [];
        $foto_tempat_produksi = json_decode($tahap2->foto_tempat_produksi ?? '[]', true) ?: [];

        // Set Data Tahap 1
        $template->setValue('nama_umk', $item->nama_pelaku ?? '-');
        $template->setValue('nama_kontak_person', $item->nama_kontak_person ?? '-');
        $template->setValue('no_hp', $item->no_hp ?? '-');
        $template->setValue('email', $item->email ?? '-');
        $template->setValue('media_sosial', $item->media_sosial ?? '-');
        $template->setValue('produk', $item->produk ?? '-');
        $template->setValue('nama_merek', $item->nama_merek ?? '-');
        $template->setValue('jenis_usaha', $item->jenis_usaha ?? '-');
        $template->setValue('tanda_daftar_merk', $item->tanda_daftar_merk ?? '-');

        // Set Data Tahap 2
        $template->setValue('alamat_kantor', $tahap2->alamat_kantor ?? '-');
        $template->setValue('provinsi_kantor', $tahap2->provinsiKantor->nama ?? '-');
        $template->setValue('kota_kantor', $tahap2->kotaKantor->nama ?? '-');
        $template->setValue('alamat_pabrik', $tahap2->alamat_pabrik ?? '-');
        $template->setValue('provinsi_pabrik', $tahap2->provinsiPabrik->nama ?? '-');
        $template->setValue('kota_pabrik', $tahap2->kotaPabrik->nama ?? '-');
        $template->setValue('legalitas_usaha', trim($legalitasFormatted));
        $template->setValue('tahun_pendirian', $tahap2->tahun_pendirian ?? '-');
        $template->setValue('sni', $tahap2->sni_yang_diterapkan ?? '-');
        $template->setValue('omzet', $tahap2->omzet ?? '-');
        $template->setValue('volume_per_tahun', $tahap2->volume_per_tahun ?? '-');
        $template->setValue('jumlah_tenaga_kerja', $tahap2->jumlah_tenaga_kerja ?? '-');
        $template->setValue('sertifikat', trim($sertifikatFormatted));
        $template->setValue('jangkauan_pemasaran', trim($jangkauanFormatted));
        $template->setValue('instansi', trim($instansiFormatted));

        // Helper nama hari bahasa Indonesia
        $hariIndonesia = function($date) {
            $days = [
                'Sunday'    => 'Minggu',
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu',
            ];
            return $days[$date->format('l')] ?? $date->format('l');
        };

        // Ambil tanggal sekarang
        $tanggalSekarang = now();

        // Set placeholder hari dengan nama hari bahasa Indonesia
        $template->setValue('hari', $hariIndonesia($tanggalSekarang));

        // Tanggal
        $template->setValue('tanggal_export', Carbon::now()->format('d-m-Y'));

        // --- Foto Produk ---
        $foto_produk = array_values($foto_produk);
        if (!empty($foto_produk)) {
            $template->cloneRow('foto_produk', count($foto_produk));
            foreach ($foto_produk as $i => $filename) {
                $key = "foto_produk#" . ($i + 1);
                $path = storage_path('app/public/' . ltrim($filename, '/'));
                if (file_exists($path)) {
                    $template->setImageValue($key, [
                        'path' => $path,
                        'width' => 100,
                        'height' => 100,
                        'ratio' => true,
                    ]);
                } else {
                    $template->setValue($key, '[Gambar tidak ditemukan]');
                }
            }
        } else {
            $template->cloneRow('foto_produk', 1);
            $template->setValue('foto_produk#1', '[Tidak ada foto]');
        }

        // --- Foto Tempat Produksi ---
        $foto_tempat_produksi = array_values($foto_tempat_produksi);
        if (!empty($foto_tempat_produksi)) {
            $template->cloneRow('foto_tempat', count($foto_tempat_produksi));
            foreach ($foto_tempat_produksi as $i => $filename) {
                $key = "foto_tempat#" . ($i + 1);
                $path = storage_path('app/public/' . ltrim($filename, '/'));
                if (file_exists($path)) {
                    $template->setImageValue($key, [
                        'path' => $path,
                        'width' => 100,
                        'height' => 100,
                        'ratio' => true,
                    ]);
                } else {
                    $template->setValue($key, '[Gambar tidak ditemukan]');
                }
            }
        } else {
            $template->cloneRow('foto_tempat', 1);
            $template->setValue('foto_tempat#1', '[Tidak ada foto]');
        }

        // Simpan dan kirim file
        $filename = 'UMKM_' . preg_replace('/[^A-Za-z0-9]/', '_', $item->nama_pelaku ?? 'unknown') . '.docx';
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
