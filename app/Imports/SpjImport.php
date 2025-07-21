<?php

namespace App\Imports;

use App\Models\Spj;
use App\Models\SpjDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SpjImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Lewati baris header
        $data = $rows->skip(1);

        // Kelompokkan berdasarkan Nama SPJ + No UKD
        $grouped = $data->groupBy(function ($row) {
            return $row[1] . '|' . $row[2]; // kolom 1 = nama_spj, kolom 2 = no_ukd
        });

        foreach ($grouped as $group) {
            $first = $group->first();

            // Simpan data utama SPJ
            $spj = new Spj();
            $spj->nama_spj = $first[1] ?? '-';             // kolom ke-1 = Nama SPJ
            $spj->no_ukd = $first[2] ?? '-';               // kolom ke-2 = No UKD
            $spj->dokumen = $first[3] ?? '-';              // kolom ke-3 = Dokumen
            $spj->keterangan = strip_tags($first[7] ?? ''); // kolom ke-7 = Keterangan
            $spj->save();

            foreach ($group as $row) {
                // Validasi item dan nominal
                if (empty($row[4]) || !is_numeric($row[5])) {
                    continue;
                }

                // Normalisasi status pembayaran
                $rawStatus = strtolower(trim($row[6] ?? 'belum_dibayar'));
                $status = str_replace(' ', '_', $rawStatus);

                // Pastikan nilainya valid enum
                if (!in_array($status, ['sudah_dibayar', 'belum_dibayar'])) {
                    $status = 'belum_dibayar'; // fallback kalau tidak valid
                }

                // Simpan detail
                $detail = new SpjDetail();
                $detail->spj_id = $spj->id;
                $detail->item = $row[4];                    // kolom ke-4 = Item
                $detail->nominal = (float) $row[5];         // kolom ke-5 = Nominal
                $detail->status_pembayaran = $status;       // kolom ke-6 = Status Pembayaran
                $detail->save();
            }
        }
    }
}
