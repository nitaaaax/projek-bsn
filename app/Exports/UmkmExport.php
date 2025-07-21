<?php

    namespace App\Exports;

    use App\Models\Tahap1;
    use Maatwebsite\Excel\Concerns\FromView;
    use Illuminate\Contracts\View\View;

    class UmkmExport implements FromView
    {
        public function view(): View
        {
            return view('umkm.export', [
                'data' => Tahap1::all()
            ]);
        }
    }
