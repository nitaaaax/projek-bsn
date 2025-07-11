@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Tambah UMKM - Tahap {{ $tahap }}</h5>
            </div>

            <div class="card-body">
            <form action="{{ route('tahap.store', [$tahap, $id ?? null]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id }}">
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                    {{-- Form Tahap Dinamis --}}
                    @includeIf('tahap.tahap' . $tahap, ['data' => $data ?? null])

                    {{-- Tombol Navigasi --}}
                    <div class="mt-4">
                        @if ($tahap > 1)
                            <a href="{{ route('tahap.create.tahap', ['tahap' => $tahap - 1, 'id' => $id ?? null]) }}"
                               class="btn btn-secondary">
                                ← Kembali
                            </a>
                        @else
                            <a href="{{ route('umkm.proses.index') }}" class="btn btn-secondary">
                                ← Kembali ke Daftar
                            </a>
                        @endif

                        @if ($tahap < 6)
                            <button type="submit" class="btn btn-primary">Lanjut →</button>
                        @else
                            <button type="submit" class="btn btn-success">Simpan</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
