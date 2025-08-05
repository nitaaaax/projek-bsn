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
        unset($rows[0]); // Skip header

        foreach ($rows as $row) {

            $tahap1 = Tahap1::create([
                'nama_pelaku'            => $row[1] ?? null,
                'produk'                 => $row[2] ?? null,
                'klasifikasi'            => $row[3] ?? null,
                'status'                 => $row[4] ?? null,
                'pembina_1'              => $row[5] ?? null,
                'pembina_2'              => $row[6] ?? null,
                'sinergi'                => $row[7] ?? null,
                'nama_kontak_person'     => $row[8] ?? null,
                'no_hp'                  => $row[9] ?? null,
                'bulan_pertama_pembinaan'=> $row[10] ?? null,
                'tahun_dibina'           => $row[11] ?? null,
                'riwayat_pembinaan'      => $this->normalizeArray($row[12] ?? null),
                'gruping'                => $row[13] ?? null,
                'email'                  => $row[14] ?? null,
                'media_sosial'           => $row[15] ?? null,
                'jenis_usaha'            => $this->normalizeJenisUsaha($row[21] ?? null),
                'nama_merek'             => $row[22] ?? null,
            ]);

            Tahap2::create([
                'pelaku_usaha_id'        => $tahap1->id,
                'alamat_kantor'          => $row[16] ?? null,
                'provinsi_kantor'        => $row[17] ?? null,
                'kota_kantor'            => $row[18] ?? null,
                'legalitas_usaha'        => $row[19] ?? null,
                'tahun_pendirian'        => $row[20] ?? null,
                'sni_yang_diterapkan'    => $row[23] ?? null,
                'lspro'                  => $row[24] ?? null,
                'omzet'                  => $row[25] ?? null,
                'volume_per_tahun'       => $row[26] ?? null,
                'jumlah_tenaga_kerja'    => isset($row[27]) ? preg_replace('/\D/', '', $row[27]) : null,
                'jangkauan_pemasaran'    => $this->normalizeArray($row[28] ?? null),
                'link_dokumen'           => $row[29] ?? null,
            ]);
        }
    }

    private function normalizeBulanNama($bulan)
    {
        $bulan = strtolower(trim($bulan));

        $mapping = [
            'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
            'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
            'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
        ];

        return $mapping[$bulan] ?? null;
    }

    private function normalizeJenisUsaha($value)
    {
        $value = strtolower(trim($value));

        if (in_array($value, ['pangan', 'p'])) {
            return 'Pangan';
        } elseif (in_array($value, ['nonpangan', 'non-pangan', 'np'])) {
            return 'Nonpangan';
        }

        return null;
    }

    private function normalizeArray($string)
    {
        return array_filter(array_map('trim', explode(',', $string)));
    }
}
