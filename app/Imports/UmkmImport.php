<?php

namespace App\Imports;

use App\Models\Tahap1;
use App\Models\Tahap2;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UmkmImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $tahap1 = Tahap1::create([
                'nama_pelaku' => $row['nama_pelaku'],
                'produk' => $row['produk'],
                'klasifikasi' => $row['klasifikasi'],
                'status' => $row['status'],
                'pembina_1' => $row['pembina_1'],
                'pembina_2' => $row['pembina_2'],
                'lspro' => $row['lspro'],
                'sinergi' => $row['sinergi'],
                'nama_kontak_person' => $row['nama_kontak_person'],
                'no_hp' => $row['no_hp'],
                'bulan_pertama_pembinaan' => $row['bulan_pertama_pembinaan'],
                'tahun_dibina' => $row['tahun_dibina'],
                'riwayat_pembinaan' => json_decode($row['riwayat_pembinaan'], true),
                'status_pembinaan' => $row['status_pembinaan'],
                'email' => $row['email'],
                'media_sosial' => $row['media_sosial'],
                'nama_merek' => $row['nama_merek'],
                'tanda_daftar_merk' => $row['tanda_daftar_merk'],
            ]);

            Tahap2::create([
                'pelaku_usaha_id' => $tahap1->id,
                'alamat_kantor' => $row['alamat_kantor'],
                'provinsi_kantor' => $row['provinsi_kantor'],
                'kota_kantor' => $row['kota_kantor'],
                'alamat_pabrik' => $row['alamat_pabrik'],
                'provinsi_pabrik' => $row['provinsi_pabrik'],
                'kota_pabrik' => $row['kota_pabrik'],
                'legalitas_usaha' => $row['legalitas_usaha'],
                'tahun_pendirian' => $row['tahun_pendirian'],
                'omzet' => $row['omzet'],
                'volume_per_tahun' => $row['volume_per_tahun'],
                'jumlah_tenaga_kerja' => $row['jumlah_tenaga_kerja'],
                'jangkauan_pemasaran' => json_decode($row['jangkauan_pemasaran'], true),
                'link_dokumen' => $row['link_dokumen'],
                'foto_produk' => json_decode($row['foto_produk'], true),
                'foto_tempat_produksi' => json_decode($row['foto_tempat_produksi'], true),
                'sni_yang_diterapkan' => $row['sni_yang_diterapkan'],
                'instansi' => json_decode($row['instansi'], true),
                'sertifikat' => $row['sertifikat'],
            ]);
        }
    }
}
