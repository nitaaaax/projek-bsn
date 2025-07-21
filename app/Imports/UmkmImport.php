<?php

namespace App\Imports;

use App\Models\Tahap1;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UmkmImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Tahap1([
            'nama_pelaku' => $row['nama_pelaku'],
            'produk' => $row['produk'],
            'status' => $row['status'],
        ]);
    }
}
