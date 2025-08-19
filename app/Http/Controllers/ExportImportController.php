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
use Illuminate\Support\Facades\DB;
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

    public function importUmkm(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120' // 5MB max size
        ]);

        DB::beginTransaction();

        try {
            Excel::import(new UmkmImport, $request->file('file'));
            
            DB::commit();

            return back()->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Data UMKM berhasil diimport!'
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Validasi Gagal',
                    'message' => 'Format file tidak valid: ' . $e->getMessage()
                ]
            ]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: {$failure->errors()[0]}";
                if ($failure->values()) {
                    $errorMessages[] = "Nilai: " . json_encode($failure->values());
                }
            }

            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Validasi Data',
                    'message' => 'Terjadi kesalahan validasi data:'
                ],
                'import_errors' => $errorMessages
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Error',
                    'message' => 'Gagal mengimport data: ' . $e->getMessage()
                ]
            ]);
        }
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
        $savePath = public_path('storage/' . $fileName); // If you want it in storage

        $templateProcessor->saveAs($savePath);

        return response()->download($savePath)->deleteFileAfterSend(true);
    }

    }
