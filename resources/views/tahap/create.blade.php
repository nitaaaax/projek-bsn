@extends('layout.app')

@section('content')
<div class="row">
  <div class="col-xl">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0">Tambah UMKM – Tahap {{ $tahap }}</h5>
      </div>

      <div class="card-body">
        <form action="{{ route('tahap.store.tahap', [$tahap, $id ?? null]) }}" method="POST">
          @csrf

          {{-- isi form dinamis --}}
          @includeIf('tahap.tahap' . $tahap, ['data' => $data])

          {{-- tombol navigasi --}}
          <div class="mt-4">
            @if ($tahap > 1)
              <a href="{{ route('tahap.create.tahap', ['tahap' => $tahap - 1, 'id' => $id ?? null]) }}"
                 class="btn btn-secondary">← Kembali</a>
            @else
              <a href="{{ route('umkm.index') }}" class="btn btn-secondary">← Daftar</a>
            @endif

            @if ($tahap < 6)
              <button class="btn btn-primary" type="submit">Lanjut →</button>
            @else
              <button class="btn btn-success" type="submit">Simpan</button>
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
