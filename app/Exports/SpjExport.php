<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SpjExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Ambil data join dari spj_details dan spjs
        $data = DB::table('spj_details')
            ->join('spjs', 'spj_details.spj_id', '=', 'spjs.id')
            ->select(
                'spjs.nama_spj',
                'spjs.no_ukd',
                'spjs.dokumen',
                'spjs.keterangan',
                'spj_details.item',
                'spj_details.nominal',
                'spj_details.status_pembayaran'
            )
            ->get();

        // Mapping dan penomoran
        return $data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Nama SPJ' => $item->nama_spj,
                'No UKD' => $item->no_ukd,
                'Dokumen' => strip_tags($item->dokumen ?? '-'),
                'Item' => $item->item,
                'Nominal' => $item->nominal,
                'Status Pembayaran' => $item->status_pembayaran,
                'Keterangan' => strip_tags($item->keterangan ?? '-'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama SPJ',
            'No UKD',
            'Dokumen',
            'Item',
            'Nominal',
            'Status Pembayaran',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        // Ambil baris terakhir
        $lastRow = $sheet->getHighestRow();

        // Tambahkan border & alignment
        $sheet->getStyle("A1:H{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Auto width kolom
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
