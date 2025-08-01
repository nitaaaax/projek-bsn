@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header">
            <h5 class="mb-0">Tambah Data UMKM</h5>
            </div>

            <div class="card-body">
            <form action="{{ route('admin.umkm.store', ['tahap' => $tahap, 'id' => $id ?? null]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
            <input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id }}">
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                    {{-- Form dinamis berdasarkan tahap --}}
                    @if ($tahap == 1)
                        @includeIf('tahap.tahap1', ['data' => $data ?? null])
                    @elseif ($tahap == 2)
                        @includeIf('tahap.tahap2', ['data' => $data ?? null])
                    @else
                        <p class="text-danger">Tahap tidak valid.</p>
                    @endif

            {{-- Navigasi tombol --}}
            <div class="mt-4 text-start ps-2">
                @if ($tahap > 1)
                    <a href="{{ route('admin.umkm.create', ['tahap' => $tahap - 1, 'id' => $id ?? null]) }}"
                    class="btn btn-outline-secondary btn-sm" style="min-width: 90px; font-size: 0.85rem;">
                       Lanjut
                    </a>

                @else
                    <a href="{{ route('umkm.proses.index') }}"
                    class="btn btn-outline-secondary btn-sm" style="min-width: 90px; font-size: 0.85rem;">
                        ← Kembali
                    </a>
                @endif

                <button type="submit"
                    class="btn btn-{{ $tahap < 2 ? 'primary' : 'success' }} btn-sm ms-2"
                    style="min-width: 90px; font-size: 0.85rem;">
                    {{ $tahap < 2 ? 'Lanjut →' : 'Simpan' }}
                </button>
            </div>


                </form>
            </div>
        </div>
    </div>
</div>
@endsection
