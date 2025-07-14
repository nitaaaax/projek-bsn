<?php

namespace App\Exports;

use App\Models\Spj;
use Maatwebsite\Excel\Concerns\FromCollection;

class SpjExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
{
    $spjList = Spj::with('details')->get();

    $data = [];
    $no = 1;

    foreach ($spjList as $spj) {
        foreach ($spj->details as $detail) {
            $data[] = [
                'No'                 => $no++,
                'Nama SPJ'           => $spj->nama_spj,
                'Item'               => $detail->item,
                'Nominal'            => $detail->nominal,
                'Status Pembayaran'  => $detail->status_pembayaran,
                'No UKD'             => $spj->no_ukd,
                'Dokumen'            => $spj->dokumen ?? '-',
                'Keterangan'         => strip_tags($spj->keterangan),
            ];
        }
    }

    return collect($data);
}


}
