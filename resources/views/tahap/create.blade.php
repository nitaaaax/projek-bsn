    @extends('layout.app')

    @section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Data UMKM</h5>
                </div>

                <div class="card-body">
                    {{-- Blade fix: gunakan $tahapNumber --}}
                    @if (in_array($tahapNumber, [1, 2]))
                    <p>Form action: {{ route('admin.umkm.store', ['tahap' => $tahapNumber, 'id' => $id ?? null]) }}</p>
                        <form action="{{ route('admin.umkm.store', ['tahap' => $tahapNumber, 'id' => $id ?? null]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                            @if ($tahapNumber == 1)
                                @includeIf('tahap.tahap1', ['data' => $data ?? null])
                            @elseif ($tahapNumber == 2)
                                @includeIf('tahap.tahap2', ['data' => $data ?? null])
                            @endif

                            <div class="mt-4 text-start ps-2">
                                @if ($tahapNumber == 1)
                                    <button type="submit"
                                        class="btn btn-primary btn-sm"
                                        style="min-width: 90px; font-size: 0.85rem;">
                                        Simpan & Lanjut →
                                    </button>
                                @elseif ($tahapNumber == 2)
                                    <a href="{{ route('admin.umkm.create.tahap', ['tahap' => 1, 'id' => $id ?? null]) }}"
                                        class="btn btn-outline-secondary btn-sm"
                                        style="min-width: 90px; font-size: 0.85rem;">
                                        ← Kembali
                                    </a>

                                    <button type="submit"
                                        class="btn btn-success btn-sm"
                                        style="min-width: 150px; font-size: 0.85rem;">
                                        Simpan 
                                    </button>
                                @endif
                            </div>

                        </form>
                    @else
                        <p class="text-danger">Tahap tidak valid.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @endsection
