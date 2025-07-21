<?php

namespace App\Http\Controllers;

use App\Models\{Tahap1, Tahap2, Tahap3, Tahap4, Tahap5, Tahap6};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
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

    public function exportWord($id)
    {
        $t1 = Tahap1::findOrFail($id);
        $t2 = Tahap2::where('pelaku_usaha_id', $id)->first();
        $t3 = Tahap3::where('pelaku_usaha_id', $id)->first();
        $t4 = Tahap4::where('pelaku_usaha_id', $id)->first();
        $t5 = Tahap5::where('pelaku_usaha_id', $id)->first();
        $t6 = Tahap6::where('pelaku_usaha_id', $id)->first();

        $templatePath = public_path('template/F.PSP 6.0.1_Form pengajuan pembinaan SNI 2020[1].docx');
        $template = new TemplateProcessor($templatePath);

        // Identitas UMKM
        $template->setValue('nama_umkm', $t1->nama_pelaku ?? '');
        $template->setValue('produk', $t1->produk ?? ''); //${nama_umk}
        $template->setValue('klasifikasi', $t1->klasifikasi ?? '');
        $template->setValue('status', $t1->status ?? '');
        $template->setValue('kontak_person', $t3->nama_kontak_person ?? '');
        $template->setValue('no_hp', $t3->No_Hp ?? '');
        $template->setValue('email', $t3->email ?? '');

        // Alamat & Lokasi
        $template->setValue('lokasi_produksi', $t4->alamat_tempat_produksi ?? '');

        // Legalitas & Sertifikasi
        $template->setValue('legalitas', $t2->legalitas_usaha ?? '');
        $template->setValue('izin_usaha', $t2->izin_usaha ?? '');
        $template->setValue('sertifikat', $t5->sertifikat ?? '');
        $template->setValue('sertifikat_halal', $t5->sertifikat_halal ?? '');
        $template->setValue('izin_edar', $t5->izin_edar ?? '');
        $template->setValue('sni', $t5->sni ? 'Ya' : 'Tidak');
        $template->setValue('tanda_daftar_merk', $t5->tanda_daftar_merk ? 'Terdaftar' : 'Belum');

        // Pembinaan
        $template->setValue('tahun_dibina', $t3->tahun_dibina ?? '');
        $template->setValue('status_pembinaan', $t3->status_pembinaan ?? '');
        $template->setValue('riwayat_pembinaan', $t3->riwayat_pembinaan ?? '');
        $template->setValue('pembina', $t3->pembina_2 ?? '');
        $template->setValue('sinergi', $t3->sinergi ?? '');

        // Produksi & SDM
        $template->setValue('omzet', $t6->omzet ?? '');
        $template->setValue('volume_produksi', $t6->volume_per_tahun ?? '');
        $template->setValue('jumlah_tk', $t6->jumlah_tenaga_kerja ?? '');
        $template->setValue('jangkauan_pemasaran', $t6->jangkauan_pemasaran ?? '');

        // Media
        $template->setValue('link_dokumen', $t6->link_dokumen ?? '');
        $template->setValue('media_sosial', $t3->media_sosial ?? '');

        // Gambar Produk
        if ($t6 && $t6->foto_produk && Storage::exists('public/' . $t6->foto_produk)) {
            $template->setImageValue('foto_produk', [
                'path' => storage_path('app/public/' . $t6->foto_produk),
                'width' => 150,
                'height' => 150
            ]);
        }

        // Gambar Tempat Produksi
        if ($t6 && $t6->foto_tempat_produksi && Storage::exists('public/' . $t6->foto_tempat_produksi)) {
            $template->setImageValue('foto_tempat', [
                'path' => storage_path('app/public/' . $t6->foto_tempat_produksi),
                'width' => 150,
                'height' => 150
            ]);
        }

        // Output file
        $filename = 'UMKM_' . str_replace(' ', '_', $t1->nama_pelaku) . '.docx';
        $savePath = storage_path('app/public/' . $filename);
        $template->saveAs($savePath);

        return response()->download($savePath)->deleteFileAfterSend(true);
    }

    

}
