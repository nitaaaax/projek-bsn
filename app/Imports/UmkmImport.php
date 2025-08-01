<?php

namespace App\Imports;

use App\Models\Tahap1;
use App\Models\Tahap2;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UmkmImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0]); // skip header

        foreach ($rows as $row) {
            // Konversi bulan
            $bulanString = $row[10] ?? null;
            $bulan = $this->convertBulanToInt($bulanString);

            $tahap1 = Tahap1::create([
                'nama_pelaku' => $row[1] ?? null,
                'produk' => $row[2] ?? null,
                'klasifikasi' => $row[3] ?? null,
                'status' => $row[4] ?? null,
                'pembina_1' => $row[5] ?? null,
                'pembina_2' => $row[6] ?? null,
                'sinergi' => $row[7] ?? null,
                'nama_kontak_person' => $row[8] ?? null,
                'no_hp' => $row[9] ?? null,
                'bulan_pertama_pembinaan' => $bulan,
                'tahun_dibina' => $row[11] ?? null,
                'riwayat_pembinaan' => explode(',', $row[12] ?? '') ?: [],
                'email' => $row[14] ?? null,
                'media_sosial' => $row[15] ?? null,
                'jenis_usaha' => $row[21] ?? null,
                'nama_merek' => $row[22] ?? null,
            ]);

            Tahap2::create([
                'pelaku_usaha_id' => $tahap1->id,
                'alamat_kantor' => $row[16] ?? null,
                'provinsi_kantor' => $row[17] ?? null,
                'kota_kantor' => $row[18] ?? null,
                'legalitas_usaha' => $row[19] ?? null,
                'tahun_pendirian' => $row[20] ?? null,
                'omzet' => $row[25] ?? null,
                'volume_per_tahun' => $row[26] ?? null,
                'jumlah_tenaga_kerja' => isset($row[27]) ? preg_replace('/\D/', '', $row[27]) : null,
                'jangkauan_pemasaran' => explode(',', $row[28] ?? '') ?: [],
                'link_dokumen' => $row[29] ?? null,
                'sni_yang_diterapkan' => $row[23] ?? null,
                'gruping' => $row[13] ?? null,
                'lspro' => $row[24] ?? null,
            ]);
        }
    }


        private function convertBulanToInt($bulan)
    {
        $mapping = [
            'januari' => 1,
            'februari' => 2,
            'maret' => 3,
            'april' => 4,
            'mei' => 5,
            'juni' => 6,
            'juli' => 7,
            'agustus' => 8,
            'september' => 9,
            'oktober' => 10,
            'november' => 11,
            'desember' => 12,
        ];

        return $mapping[strtolower(trim($bulan))] ?? null;
    }

}
