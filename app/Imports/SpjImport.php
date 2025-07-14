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
        foreach ($rows as $index => $row) {
            // Lewati baris pertama jika itu header
            if ($index === 0) continue;

            $spj = Spj::create([
                'nama_spj'   => $row[1],
                'no_ukd'     => $row[5] ?? null,
                'dokumen'    => $row[6] ?? null,
                'keterangan' => $row[7] ?? null,
            ]);

            SpjDetail::create([
                'spj_id'            => $spj->id,
                'item'              => $row[2],
                'nominal'           => $row[3],
                'status_pembayaran' => $row[4],
                'keterangan'        => null,
            ]);
        }
    }
}
