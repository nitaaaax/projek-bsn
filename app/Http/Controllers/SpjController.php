<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\SpjDetail;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class SpjController extends Controller
{
    // Menampilkan semua data SPJ
    public function index()
    {
        $spj = Spj::with('details')->get();

        // Ambil semua detail yang sudah/ belum dibayar
        $sudahBayar = \App\Models\SpjDetail::with('spj')
                        ->where('status_pembayaran', 'sudah_dibayar')->get();

        $belumBayar = \App\Models\SpjDetail::with('spj')
                        ->where('status_pembayaran', 'belum_dibayar')->get();

        return view('spj.index', compact('spj', 'sudahBayar', 'belumBayar'));
    }

      public function exportWord()
{
    $spjs = \App\Models\Spj::with('details')->get();

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $phpWord->setDefaultFontName('Calibri');
    $phpWord->setDefaultFontSize(11);

    $section = $phpWord->addSection([
        'marginTop' => 600,
        'marginBottom' => 600,
        'marginLeft' => 800,
        'marginRight' => 800,
    ]);

    $section->addText(
        'LAPORAN SPJ',
        ['bold' => true, 'size' => 16, 'underline' => 'single'],
        ['alignment' => 'center', 'spaceAfter' => 200]
    );
    $section->addTextBreak(1);

    // Style tabel
    $tableStyle = [
        'borderSize' => 8,
        'borderColor' => '000000',
        'cellMargin' => 100,
        'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
    ];

    $headerFont = ['bold' => true, 'color' => '1F4E78'];
    $headerCellStyle = [
        'valign' => 'center',
        'bgColor' => 'E6F9F2', // Mint
    ];

    $phpWord->addTableStyle('Fancy Table', $tableStyle);
    $table = $section->addTable('Fancy Table');

    // Lebar tiap kolom (twip)
    $columnWidths = [
        1800, // Nama SPJ
        1800, // Item
        1500, // Nominal
        2500, // Status Pembayaran
        1000, // No UKD
        2500, // Dokumen
        1900, // Keterangan
    ];

    $headers = ['Nama SPJ', 'Item', 'Nominal', 'Status Pembayaran', 'No UKD', 'Dokumen', 'Keterangan'];

    // Header row
    $table->addRow(500);
    foreach ($headers as $i => $header) {
        $table->addCell($columnWidths[$i], $headerCellStyle)
              ->addText($header, $headerFont, ['alignment' => 'center']);
    }

    // Isi data
    foreach ($spjs as $spj) {
        foreach ($spj->details as $detail) {
            $table->addRow();
            $table->addCell($columnWidths[0])->addText($spj->nama_spj);
            $table->addCell($columnWidths[1])->addText($detail->item);
            $table->addCell($columnWidths[2])->addText('Rp' . number_format($detail->nominal, 0, ',', '.'));
            $table->addCell($columnWidths[3])->addText($detail->status_pembayaran);
            $table->addCell($columnWidths[4])->addText($spj->no_ukd ?? '-');
            $table->addCell($columnWidths[5])->addText($spj->dokumen ?? '-');
            $table->addCell($columnWidths[6])->addText(strip_tags($spj->keterangan ?? '-'));
        }
    }

    // Simpan dan unduh
    $fileName = 'laporan_spj.docx';
    $tempPath = storage_path($fileName);
    $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($tempPath);

    return response()->download($tempPath)->deleteFileAfterSend(true);
}



            public function importWord(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]);

        $file = $request->file('file');
        $phpWord = IOFactory::load($file->getPathname());

        $tables = $phpWord->getSections()[0]->getElements();

        // Fungsi bantu buat ambil teks dari cell
        $getCellText = function($cell) {
            $elements = $cell?->getElements();
            if (!empty($elements) && method_exists($elements[0], 'getText')) {
                return $elements[0]->getText();
            }
            return '';
        };

        foreach ($tables as $element) {
            if ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                $rows = $element->getRows();

                // Lewati header (baris pertama)
                foreach ($rows as $index => $row) {
                    if ($index === 0) continue;

                    $cells = $row->getCells();

                    $nama_spj   = $getCellText($cells[0]);
                    $item       = $getCellText($cells[1]);
                    $nominalRaw = $getCellText($cells[2]);
                    $status     = $getCellText($cells[3]) ?: 'belum_dibayar';
                    $no_ukd     = $getCellText($cells[4]) ?: null;
                    $dokumen    = $getCellText($cells[5]) ?: null;
                    $keterangan = $getCellText($cells[6]) ?: null;

                    $nominal = (int) str_replace(['Rp', '.', ','], '', $nominalRaw);

                    // Cek apakah SPJ ini sudah ada
                    $spj = Spj::firstOrCreate(
                        ['nama_spj' => $nama_spj],
                        ['no_ukd' => $no_ukd, 'dokumen' => $dokumen, 'keterangan' => $keterangan]
                    );

                    // Tambahkan detailnya
                    SpjDetail::create([
                        'spj_id' => $spj->id,
                        'item' => $item,
                        'nominal' => $nominal,
                        'status_pembayaran' => $status,
                        'keterangan' => $keterangan
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Import dari Word berhasil.');
    }


    // Form tambah SPJ
    public function create()
    {
        return view('spj.create');
    }

    // Simpan data SPJ dan semua detailnya
    public function store(Request $request)
    {
        $request->validate([
            'nama_spj'             => 'required|string|max:255',
            'no_ukd'               => 'nullable|string|max:255',
            'keterangan'           => 'nullable|string',
            'item.*'               => 'required|string',
            'nominal.*'            => 'required|numeric|min:0',
            'status_pembayaran.*'  => 'required|in:belum_dibayar,sudah_dibayar',
            'keterangan_detail.*'  => 'nullable|string',
            'dokumen'              => 'nullable|string|max:255',
        ]);

        // Simpan data utama SPJ
        $spj = Spj::create([
            'nama_spj'   => $request->nama_spj,
            'no_ukd'     => $request->no_ukd,
            'keterangan' => $request->keterangan,
            'dokumen'    => $request->dokumen, // ini yang ditambahkan
        ]);

        // Simpan detail SPJ
        foreach ($request->item as $i => $item) {
            SpjDetail::create([
                'spj_id'            => $spj->id,
                'item'              => $item,
                'nominal'           => $request->nominal[$i],
                'status_pembayaran' => $request->status_pembayaran[$i],
                'keterangan'        => $request->keterangan_detail[$i] ?? null,
            ]);
        }

        return redirect()->route('spj.index')->with('success', 'Data SPJ berhasil disimpan.');
    }

    // Tampilkan detail SPJ
    public function show($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        return view('spj.show', compact('spj'));
    }

    // Form edit SPJ
    public function edit($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        return view('spj.edit', compact('spj'));
    }

    // Update SPJ dan semua detail item-nya
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_spj'      => 'required|string|max:255',
            'no_ukd'        => 'nullable|string|max:255',
            'keterangan'    => 'nullable|string',
            'item.*'        => 'required|string',
            'nominal.*'     => 'required|numeric|min:0',
            'pembayaran.*'  => 'required|in:belum_dibayar,sudah_dibayar',
        ]);

        $spj = Spj::findOrFail($id);
        $spj->update([
            'nama_spj'   => $request->nama_spj,
            'no_ukd'     => $request->no_ukd,
            'keterangan' => $request->keterangan,
        ]);

        // Hapus semua detail lama
        $spj->details()->delete();

        // Simpan ulang semua detail
        foreach ($request->item as $i => $item) {
            SpjDetail::create([
                'spj_id'            => $spj->id,
                'item'              => $item,
                'nominal'           => $request->nominal[$i],
                'status_pembayaran' => $request->pembayaran[$i],
            ]);
        }

        return redirect()->route('spj.show', $spj->id)->with('success', 'SPJ berhasil diupdate.');
    }

    // Hapus SPJ dan semua detailnya
    public function destroy($id)
    {
        $spj = Spj::findOrFail($id);
        $spj->details()->delete();
        $spj->delete();

        return redirect()->route('spj.index')->with('success', 'Data berhasil dihapus.');
    }
}
