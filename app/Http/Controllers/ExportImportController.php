<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UmkmImport;
use App\Models\Tahap1;
use App\Models\Tahap2;
use App\Models\SpjDetail;
use PhpOffice\PhpWord\Element\TextRun;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ExportImportController extends Controller
{
    public function index()
    {
        // Only show files from public/template (remove storage files if you want direct access)
        $files = array_filter(Storage::files('public/template'), function($file) {
            return !Str::contains($file, '.gitignore'); // Exclude .gitignore if present
        });

        $files = array_map(function($file) {
            return [
                'name' => basename($file),
                'path' => $file,
                'size' => Storage::size($file),
                'modified' => Storage::lastModified($file)
            ];
        }, $files);

        return view('admin.templates.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:doc,docx,xls,xlsx|max:2048',
        ]);

        $filename = $request->file('file')->getClientOriginalName();
        
        if (Storage::exists('public/template/'.$filename)) {
            return back()->withErrors(['file' => 'File dengan nama ini sudah ada.']);
        }

        $request->file('file')->storeAs('public/template', $filename);

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template berhasil diupload.');
    }
    
    public function update(Request $request, $oldFilename)
    {
        try {
            $oldFilename = urldecode($oldFilename);

            $request->validate([
                'file' => 'required|file|mimes:doc,docx,xls,xlsx|max:2048',
            ]);

            $newFile = $request->file('file');

            if (!$newFile || !$newFile->isValid()) {
                throw new \Exception('File upload tidak valid');
            }

            $publicPath = public_path('template');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }

            $oldFilePath = $publicPath . DIRECTORY_SEPARATOR . $oldFilename;

            // Gunakan fungsi native PHP untuk pindahkan file upload langsung ke path baru
            // Tapi sebelum itu, hapus file lama kalau ada
            if (file_exists($oldFilePath)) {
                // Coba set permission dulu
                @chmod($oldFilePath, 0777);
                if (!unlink($oldFilePath)) {
                    throw new \Exception("Gagal hapus file lama: $oldFilePath");
                }
            }

            // Pindahkan file baru ke lokasi file lama (nama file lama)
            $tmpPath = $newFile->getPathname();

            if (!rename($tmpPath, $oldFilePath)) {
                // Jika rename gagal, coba copy dan hapus tmp
                if (!copy($tmpPath, $oldFilePath)) {
                    throw new \Exception("Gagal pindahkan file baru ke $oldFilePath");
                }
                unlink($tmpPath);
            }

            return redirect()
                ->route('admin.templates.index')
                ->with('success', 'File berhasil diganti dengan yang baru.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Error update file: ' . $e->getMessage()]);
        }
    }

    public function destroy($filename)
    {
        try {
            $storagePath = 'template/'.$filename;
            $publicPath = 'public/template/'.$filename;
            
            $deleted = false;
            
            if (Storage::exists($storagePath)) {
                Storage::delete($storagePath);
                $deleted = true;
            }
            
            if (Storage::exists($publicPath)) {
                Storage::delete($publicPath);
                $deleted = true;
            }
            
            if ($deleted) {
                return redirect()
                    ->route('admin.templates.index')
                    ->with('success', 'Template berhasil dihapus.');
            }
            
            return redirect()
                ->route('admin.templates.index')
                ->withErrors(['File tidak ditemukan.']);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Gagal menghapus template: '.$e->getMessage()]);
        }
    }

    public function exportUmkm($id)
    {
        $item = Tahap1::findOrFail($id);
        $tahap2 = Tahap2::with(['provinsiKantor', 'kotaKantor', 'provinsiPabrik', 'kotaPabrik'])
            ->where('pelaku_usaha_id', $item->id)
            ->first();

        if (!$tahap2) {
            abort(404, 'Data Tahap 2 tidak ditemukan.');
        }

         $templatePath = public_path('storage/template/template_eksporumkm.docx');
         $exportPath = public_path('exports');

        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        $template = new TemplateProcessor($templatePath);

        // --- Jangkauan Pemasaran ---
      $jangkauanRaw = $tahap2->jangkauan_pemasaran ?? '[]';
    $jangkauanArr = is_array($jangkauanRaw) ? $jangkauanRaw : json_decode($jangkauanRaw, true);
    if (!is_array($jangkauanArr)) $jangkauanArr = [];

    $jangkauanKeys = ['Local', 'Nasional', 'Internasional', 'Lainnya'];
    foreach ($jangkauanKeys as $key) {
        if (!isset($jangkauanArr[$key])) {
            // khusus Lainnya, coba cari key yang mengandung kata "lainnya"
            if ($key === 'Lainnya') {
                $altKey = collect(array_keys($jangkauanArr))
                    ->first(fn($k) => stripos($k, 'lainnya') !== false);
                $jangkauanArr[$key] = $altKey ? $jangkauanArr[$altKey] : "-";
            } else {
                $jangkauanArr[$key] = "-";
            }
        }
        // pastikan string
        $jangkauanArr[$key] = trim((string)$jangkauanArr[$key]) !== '' ? $jangkauanArr[$key] : "-";
    }

    $jangkauanFormatted = "a. Local\n{$jangkauanArr['Local']}\n\n" .
        "b. Nasional\n{$jangkauanArr['Nasional']}\n\n" .
        "c. Internasional\n{$jangkauanArr['Internasional']}\n\n" .
        "d. Lainnya\n{$jangkauanArr['Lainnya']}\n\n";



        
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
                $path = public_path('app/public/' . ltrim($filename, '/'));
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
                $path = public_path('app/public/' . ltrim($filename, '/'));
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

    public function importUmkm(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new UmkmImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimport!');
    }

    public function exportSpj($detailId)
    {
        $detail = SpjDetail::with('spj')->findOrFail($detailId);
        $spj = $detail->spj;

         $templatePath = public_path('storage/template/template_ekspor_spj.docx');
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
        $savePath = public_path('app/public/' . $fileName);

        $templateProcessor->saveAs($savePath);

        return response()->download($savePath)->deleteFileAfterSend(true);
    }

    }
