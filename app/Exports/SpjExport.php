<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SpjExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil data join spjs + spj_details
        $data = DB::table('spj_details')
            ->join('spjs', 'spj_details.spj_id', '=', 'spjs.id')
            ->select(
                'spjs.nama_spj',
                'spjs.no_ukd',
                'spj_details.item',
                'spj_details.nominal',
                'spj_details.status_pembayaran',
                'spj_details.keterangan'
            )
            ->get();

        // Tambahkan nomor urut manual
        $numbered = $data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Nama SPJ' => $item->nama_spj,
                'No UKD' => $item->no_ukd,
                'Item' => $item->item,
                'Nominal' => $item->nominal,
                'Status Pembayaran' => $item->status_pembayaran,
                'Keterangan Item' => $item->keterangan,
            ];
        });

        return $numbered;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama SPJ',
            'No UKD',
            'Item',
            'Nominal',
            'Status Pembayaran',
            'Keterangan Item',
        ];
    }
}


