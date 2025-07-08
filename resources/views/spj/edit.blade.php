@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h2 class="mb-4">Edit SPJ</h2>

      <form action="{{ route('spj.update', $spj->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama & No UKD --}}
        <div class="row">
  <div class="col-md-6 mb-3">
    <label for="nama_spj" class="form-label">Nama SPJ</label>
    <input type="text" class="form-control" name="nama_spj" value="{{ old('nama_spj', $spj->nama_spj) }}">
  </div>

  <div class="col-md-6 mb-3">
    <label for="no_ukd" class="form-label">No UKD</label>
    <input type="text" class="form-control" name="no_ukd" value="{{ old('no_ukd', $spj->no_ukd) }}">
  </div>

  <div class="mb-4">
    <label for="keterangan" class="form-label"><strong>Keterangan</strong></label>
    <textarea name="keterangan" id="editor1" class="form-control" rows="5" placeholder="Tambahkan keterangan ">{{ old('keterangan', $spj->keterangan) }}</textarea>
  </div>

  <div class="col-md-6 mb-3">
    <label for="dokumen" class="form-label">Link Dokumen</label>
    <input type="text" class="form-control" name="dokumen" value="{{ old('dokumen', $spj->dokumen) }}">
  </div> 
</div>


        {{-- Tabel Item --}}
        <div class="table-responsive mb-3">
          <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
              <tr>
                <th style="width: 40%">Item</th>
                <th style="width: 25%">Nominal (Rp)</th>
                <th style="width: 25%">Status Pembayaran</th>
                <th style="width: 10%">Aksi</th>
              </tr>
            </thead>
            <tbody id="items">
              @foreach ($spj->details as $detail)
              <tr>
                <td><input type="text" name="item[]" class="form-control" value="{{ $detail->item }}" required></td>
                <td><input type="number" name="nominal[]" class="form-control nominal" value="{{ $detail->nominal }}" required></td>
                <td>
                  <select name="pembayaran[]" class="form-control" required>
                    <option value="belum_dibayar" {{ $detail->status_pembayaran == 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                    <option value="sudah_dibayar" {{ $detail->status_pembayaran == 'sudah_dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                  </select>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    

        <div class="mb-3 text-end">
          <button type="button" class="btn btn-success" id="add-item">+ Tambah Item</button>
        </div>
        <div class="form-group">
  

        <div class="mb-4">
          <h5>Total: <span id="total-rp">Rp 0</span></h5>
        </div>

        <button type="submit" class="btn btn-primary">Update SPJ</button>
      </form>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysihtml5-bower/0.3.3/bootstrap3-wysihtml5.min.css" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysihtml5-bower/0.3.3/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  function updateTotal() {
    let total = 0;
    document.querySelectorAll('.nominal').forEach(input => {
      total += parseInt(input.value) || 0;
    });
    document.getElementById('total-rp').textContent = 'Rp ' + total.toLocaleString('id-ID');
  }

  document.getElementById('add-item').addEventListener('click', function () {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><input type="text" name="item[]" class="form-control" required></td>
      <td><input type="number" name="nominal[]" class="form-control nominal" required></td>
      <td>
        <select name="pembayaran[]" class="form-control" required>
          <option value="belum_dibayar">Belum Dibayar</option>
          <option value="sudah_dibayar">Sudah Dibayar</option>
        </select>
      </td>
      <td><button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button></td>
    `;
    document.getElementById('items').appendChild(row);
    updateTotal();
  });

  document.addEventListener('input', function (e) {
    if (e.target.classList.contains('nominal')) {
      updateTotal();
    }
  });

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-item')) {
      e.target.closest('tr').remove();
      updateTotal();
    }
  });

  $(document).ready(function () {
    $('.wysihtml5').wysihtml5();
    updateTotal();
  });
</script>
@endpush
@push('scripts')
  <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('editor1');
  </script>
@endpush
