@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h2 class="mb-4">Edit SPJ</h2>

      <form action="{{ route('spj.update', $spj->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row mb-3">
              <div class="col-md-6">
                  <label for="nama_spj"><strong>Nama SPJ</strong></label>
                  <input type="text" name="nama_spj" class="form-control" value="{{ $spj->nama_spj }}" required>
              </div>
              <div class="col-md-6">
                  <label for="no_ukd"><strong>No UKD</strong></label>
                  <input type="text" name="no_ukd" class="form-control" value="{{ $spj->no_ukd }}" required>
              </div>
          </div>

          <div class="mb-4">
              <label for="keterangan"><strong>Keterangan</strong></label>
              <textarea name="keterangan" class="form-control" rows="2">{{ $spj->keterangan }}</textarea>
          </div>

          <div class="table-responsive">
              <table class="table table-bordered align-middle text-center">
                  <thead class="thead-light">
                      <tr>
                          <th style="width: 40%">Item</th>
                          <th style="width: 30%">Nominal (Rp)</th>
                          <th style="width: 20%">Status Pembayaran</th>
                          <th style="width: 10%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody id="items">
                      @foreach ($spj->details as $detail)
                          <tr>
                              <td>
                                  <input type="text" name="item[]" class="form-control" value="{{ $detail->item }}" required>
                              </td>
                              <td>
                                  <input type="number" name="nominal[]" class="form-control nominal" value="{{ $detail->nominal }}" required>
                              </td>
                              <td>
                                  <select name="pembayaran[]" class="form-control" required>
                                      <option value="belum_dibayar" {{ $detail->status_pembayaran == 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                      <option value="sudah_dibayar" {{ $detail->status_pembayaran == 'sudah_dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                                  </select>
                              </td>
                              <td>
                                  <button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>

          <div class="mb-3 text-end">
              <button type="button" class="btn btn-success" id="add-item">+ Tambah Item</button>
          </div>

          <div class="mb-4">
              <h5>Total: <span id="total-rp">Rp 0</span></h5>
          </div>

          <button type="submit" class="btn btn-primary">Update SPJ</button>
      </form>
    </div>
  </div>
</div>

{{-- SCRIPT --}}
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

    updateTotal();
</script>
@endsection
