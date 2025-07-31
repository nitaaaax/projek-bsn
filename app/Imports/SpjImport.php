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
        $spj = null;
        $allowedStatuses = ['sudah dibayar', 'belum dibayar'];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // skip header

            $nama_spj = trim($row[1] ?? '');
            $no_ukd = trim($row[2] ?? '');
            $dokumen = trim($row[3] ?? '');
            $keterangan = trim($row[4] ?? '');
            $item_string = trim($row[5] ?? '');

            // skip baris jika nama SPJ kosong
            if (empty($nama_spj)) continue;

            // Buat SPJ utama
            $spj = Spj::create([
                'nama_spj'   => $nama_spj,
                'no_ukd'     => $no_ukd,
                'dokumen'    => $dokumen,
                'keterangan' => $keterangan,
            ]);

            // Pecah detail berdasarkan koma jika ada banyak
            $items = explode(',', $item_string);
            foreach ($items as $itemData) {
                $parts = explode('/', $itemData);
                $item = $parts[0] ?? null;
                $nominal = isset($parts[1]) && is_numeric($parts[1]) ? intval($parts[1]) : 0;
                $status = isset($parts[2]) && in_array(strtolower(trim($parts[2])), $allowedStatuses)
                            ? strtolower(trim($parts[2]))
                            : null;

                if ($item) {
                    SpjDetail::create([
                        'spj_id'            => $spj->id,
                        'item'              => trim($item),
                        'nominal'           => $nominal,
                        'status_pembayaran' => $status,
                        'keterangan'        => $keterangan,
                    ]);
                }
            }
        }
    }
}
