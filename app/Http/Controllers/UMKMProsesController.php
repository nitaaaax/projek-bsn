<?php

namespace App\Http\Controllers;

use App\Models\{Tahap1, Tahap2, Tahap3, Tahap4, Tahap5, Tahap6};
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UmkmExport;
use App\Imports\UmkmImport;
use Illuminate\Support\Facades\Storage;

class UMKMProsesController extends Controller
{
  public function index()
{
    $tahap1 = Tahap1::where('status', '!=', 'Tersertifikasi')
        ->with(['tahap2', 'tahap3', 'tahap4', 'tahap5', 'tahap6'])
        ->get();

    return view('umkm.proses.index', compact('tahap1'));
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

        return redirect()->route('umkm.sertifikasi.index')->with('success', 'Data berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelaku' => 'required|string|max:255',
            'produk' => 'required|string|max:255',
            'klasifikasi' => 'required|string|max:255',
            'status' => 'required|string|max:100',
            'pembina_1' => 'nullable|string|max:255',
            'pembina_2' => 'nullable|string|max:255',
            'sinergi' => 'nullable|string|max:255',
            'nama_kontak_person' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'bulan_pertama_pembinaan' => 'required|integer|min:1|max:12',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_tempat_produksi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $umkm = Tahap1::with(['tahap2', 'tahap3', 'tahap4', 'tahap5', 'tahap6'])->findOrFail($id);

        $umkm->update([
            'nama_pelaku' => $request->nama_pelaku,
            'produk' => $request->produk,
            'klasifikasi' => $request->klasifikasi,
            'status' => $request->status,
            'pembina_1' => $request->pembina_1,
        ]);

        if ($umkm->tahap2) {
            $umkm->tahap2->update([
                'pembina_2' => $request->pembina_2,
                'sinergi' => $request->sinergi,
                'nama_kontak_person' => $request->nama_kontak_person,
                'no_hp' => $request->no_hp,
                'bulan_pertama_pembinaan' => $request->bulan_pertama_pembinaan,
            ]);
        }

        if ($umkm->tahap3) {
            $umkm->tahap3->update([
                'tahun_dibina' => $request->tahun_dibina,
                'riwayat_pembinaan' => $request->riwayat_pembinaan,
                'status_pembinaan' => $request->status_pembinaan,
                'email' => $request->email,
                'media_sosial' => $request->media_sosial,
            ]);
        }

        if ($umkm->tahap4) {
            $umkm->tahap4->update([
                'alamat' => $request->alamat,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'legalitas_usaha' => $request->legalitas_usaha,
                'tahun_pendirian' => $request->tahun_pendirian,
            ]);
        }

        if ($umkm->tahap5) {
            $umkm->tahap5->update([
                'jenis_usaha' => $request->jenis_usaha,
                'nama_merek' => $request->nama_merek,
                'sni' => $request->sni,
                'lspro' => $request->lspro,
                'tanda_daftar_merk' => $request->tanda_daftar_merk,
            ]);
        }

        if ($umkm->tahap6) {
            $data = [
                'omzet' => $request->omzet,
                'volume_per_tahun' => $request->volume_per_tahun,
                'jumlah_tenaga_kerja' => $request->jumlah_tenaga_kerja,
                'jangkauan_pemasaran' => $request->jangkauan_pemasaran,
                'link_dokumen' => $request->link_dokumen,
                'gambar_produk' => $request->gambar_produk,
                'gambar_tempat_produksi' => $request->gambar_tempat_produksi,
                'dokumen_mutu' => $request->dokumen_mutu,
            ];

            if ($request->hasFile('foto_produk')) {
                if ($umkm->tahap6->foto_produk) {
                    Storage::disk('public')->delete($umkm->tahap6->foto_produk);
                }
                $filename = time() . '_produk.' . $request->file('foto_produk')->getClientOriginalExtension();
                $path = $request->file('foto_produk')->storeAs('uploads/foto_produk', $filename, 'public');
                $data['foto_produk'] = $path;
            }

            if ($request->hasFile('foto_tempat_produksi')) {
                if ($umkm->tahap6->foto_tempat_produksi) {
                    Storage::disk('public')->delete($umkm->tahap6->foto_tempat_produksi);
                }
                $filename = time() . '_tempat.' . $request->file('foto_tempat_produksi')->getClientOriginalExtension();
                $path = $request->file('foto_tempat_produksi')->storeAs('uploads/foto_tempat_produksi', $filename, 'public');
                $data['foto_tempat_produksi'] = $path;
            }

            $umkm->tahap6->update($data);
        }

        if ($request->status_pembinaan == 'SPPT SNI') {
            $umkm->status = 'Tersertifikasi';
            $umkm->save();

            return redirect()->route('umkm.sertifikasi.index')
                ->with('success', 'UMKM berhasil dipindahkan ke Sertifikasi.');
        }

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new UmkmImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data berhasil diimpor!');
    }

    public function export()
    {
        return Excel::download(new UmkmExport, 'data_umkm.docx');
    }

    public function exportWord()
    {
        $data = Tahap1::all();
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Judul
        $section->addTitle('Rekapitulasi Data UMKM', 1);
        $section->addTextBreak(1);

        // Style tabel
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50
        ];
        $firstRowStyle = ['bgColor' => 'DDDDDD'];
        $phpWord->addTableStyle('Data UMKM', $tableStyle, $firstRowStyle);

        foreach ($data as $item) {
            $pembinaan = Tahap2::where('pelaku_usaha_id', $item->id)->first();
            $alamat    = Tahap4::where('pelaku_usaha_id', $item->id)->first();
            $usaha     = Tahap5::where('pelaku_usaha_id', $item->id)->first();
            $produksi  = Tahap6::where('pelaku_usaha_id', $item->id)->first();

            $section->addText('UMKM: ' . $item->nama_pelaku, ['bold' => true, 'size' => 14]);
            $section->addTextBreak(0.5);

            $table = $section->addTable('Data UMKM');

            $table->addRow();
            $table->addCell(4000)->addText('Field', ['bold' => true]);
            $table->addCell(8000)->addText('Value', ['bold' => true]);

            $table->addRow();
            $table->addCell()->addText('Nama Pelaku / UMK');
            $table->addCell()->addText($item->nama_pelaku);

            $table->addRow();
            $table->addCell()->addText('Nama Produk');
            $table->addCell()->addText($item->produk);

            $table->addRow();
            $table->addCell()->addText('Jenis Usaha');
            $table->addCell()->addText($usaha->jenis_usaha ?? '-');

            $table->addRow();
            $table->addCell()->addText('Tahun Berdiri');
            $table->addCell()->addText($alamat->tahun_pendirian ?? '-');

            $table->addRow();
            $table->addCell()->addText('Legalitas Usaha');
            $table->addCell()->addText($alamat->legalitas_usaha ?? '-');

            $table->addRow();
            $table->addCell()->addText('Omzet');
            $table->addCell()->addText($produksi->omzet ?? '-');

            $table->addRow();
            $table->addCell()->addText('Jangkauan Pemasaran');
            $table->addCell()->addText($produksi->jangkauan_pemasaran ?? '-');

            $table->addRow();
            $table->addCell()->addText('Kontak Person');
            $table->addCell()->addText($pembinaan->nama_kontak_person ?? '-');

            $table->addRow();
            $table->addCell()->addText('No HP');
            $table->addCell()->addText($pembinaan->No_Hp ?? '-');

            $table->addRow();
            $table->addCell()->addText('Email');
            $table->addCell()->addText($item->email ?? '-');

            $table->addRow();
            $table->addCell()->addText('Lokasi Usaha');
            $lokasi = trim(($alamat->kota ?? '') . ', ' . ($alamat->provinsi ?? ''));
            $table->addCell()->addText($lokasi);

            $section->addTextBreak(1);
        }

        $fileName = 'data_umkm_filtered.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'umkm_') . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

}
