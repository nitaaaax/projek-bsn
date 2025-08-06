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


        // Jika tidak ada tahap2, maka isi dengan default kosong
        $jangkauan = '-';
        $foto_produk = [];
        $foto_tempat_produksi = [];
        $instansiFormatted = '-';

        if ($tahap2) {
            // Jangkauan Pemasaran
        
        }

        $templatePath = public_path('template/template_eksporumkm.docx');
        $exportPath = storage_path('app/public/exports');

        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        $template = new TemplateProcessor($templatePath);

        // Jangkauan Pemasaran
        $jangkauan = $tahap2->jangkauan_pemasaran ?? '-';
        if (is_array($jangkauan)) {
            $jangkauan = implode(', ', $jangkauan);
        } elseif (is_string($jangkauan)) {
            $decoded = json_decode($jangkauan, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $jangkauan = implode(', ', $decoded);
            }
        }

        // Decode foto
        $foto_produk = json_decode($tahap2->foto_produk ?? '[]', true);
        $foto_tempat_produksi = json_decode($tahap2->foto_tempat_produksi ?? '[]', true);

        // Instansi
        $instansiFormatted = '-';
        $instansiDecoded = json_decode($tahap2->instansi ?? '{}', true);
        if (is_array($instansiDecoded) && !empty($instansiDecoded)) {
            $instansiFormatted = implode("\n", array_map(function ($label, $detail) {
                return '• ' . $label . ($detail ? ": $detail" : '');
            }, array_keys($instansiDecoded), $instansiDecoded));
        }

        $legalitasList = [
            'NIB' => 'a) NIB',
            'IUMK' => 'b) IUMK',
            'SIUP' => 'c) SIUP',
            'TDP' => 'd) TDP',
            'NPWP Pemilik' => 'e) NPWP Pemilik',
            'NPWP Badan Usaha' => 'f) NPWP Badan Usaha',
            'Akta Pendirian Usaha' => 'g) Akta Pendirian Usaha',
        ];

        // Ambil legalitas dari database
        $legalitas = json_decode($tahap2->legalitas_usaha, true) ?? [];

        // Siapkan hasil final
        $legalitasFormatted = '';
        foreach ($legalitasList as $key => $label) {
            $tersedia = in_array($key, $legalitas) ? ' Tersedia' : '-';
            $legalitasFormatted .= "$label : $tersedia\n";
        }

        // Tangani bagian "Lainnya"
        $lainnya = collect($legalitas)->first(function ($item) {
            return str_starts_with($item, 'Lainnya:');
        });
        if ($lainnya) {
            $keterangan = trim(str_replace('Lainnya:', '', $lainnya));
            $legalitasFormatted .= "h) Lainnya : $keterangan";
        } else {
            $legalitasFormatted .= "h) Lainnya : -";
        }

        $template->setValue('legalitas_usaha', $legalitasFormatted);


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
        $template->setValue('legalitas_usaha', $legalitasFormatted);
        $template->setValue('tahun_pendirian', $tahap2->tahun_pendirian ?? '-');
        $template->setValue('sni', $tahap2->sni_yang_diterapkan ?? '-');
        $template->setValue('omzet', $tahap2->omzet ?? '-');
        $template->setValue('volume_per_tahun', $tahap2->volume_per_tahun ?? '-');
        $template->setValue('jumlah_tenaga_kerja', $tahap2->jumlah_tenaga_kerja ?? '-');
        $template->setValue('sertifikat', $tahap2->sertifikat ?? '-');
        $template->setValue('jangkauan_pemasaran', $jangkauan);
        $template->setValue('instansi', $instansiFormatted);

        // Tanggal
        $template->setValue('tanggal_export', Carbon::now()->format('d-m-Y'));

        // --- Foto Produk
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

        // --- Foto Tempat Produksi
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
        $filename = 'UMKM_' . preg_replace('/[^A-Za-z0-9]/', '_', $item->nama_pelaku) . '.docx';
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
