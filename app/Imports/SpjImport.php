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
            if ($index === 0) continue; // skip header

            $nama_spj   = trim($row[1] ?? '');
            $no_ukd     = trim($row[2] ?? '');
            $dokumen    = trim($row[3] ?? '');
            $keterangan = trim($row[4] ?? '');
            $item_string = trim($row[5] ?? '');

            if (empty($nama_spj)) continue;

            // Buat SPJ
            $spj = Spj::create([
                'nama_spj'   => $nama_spj,
                'no_ukd'     => $no_ukd,
                'dokumen'    => $dokumen,
                'keterangan' => $keterangan,
            ]);

            // Mapping status agar sesuai enum database
            $allowedStatuses = [
                'sudah dibayar' => 'Sudah Dibayar',
                'belum dibayar' => 'Belum Dibayar',
            ];

            // Pisahkan item per koma
            $items = explode(',', $item_string);
            foreach ($items as $itemData) {
                $parts = explode('/', $itemData);

                $item = trim($parts[0] ?? '');
                $nominal = isset($parts[1]) && is_numeric($parts[1]) ? intval($parts[1]) : 0;

                // Ambil dan normalkan status
                $raw_status = strtolower(trim($parts[2] ?? 'belum dibayar'));

                $status = $allowedStatuses[$raw_status] ?? 'Belum Dibayar'; // fallback aman

                if (!empty($item)) {
                    SpjDetail::create([
                        'spj_id'            => $spj->id,
                        'item'              => $item,
                        'nominal'           => $nominal,
                        'status_pembayaran' => $status,
                        'keterangan'        => $keterangan,
                    ]);
                }
            }
        }
    }
}
