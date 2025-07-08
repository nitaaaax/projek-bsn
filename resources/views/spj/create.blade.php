@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h4 class="mb-4">Form Input SPJ</h4>

      <form action="{{ route('spj.store') }}" method="POST">
          @csrf

          {{-- Nama SPJ, No UKD --}}
          <div class="row mb-3">
              <div class="col-md-6">
                  <label for="nama_spj" class="form-label"><strong>Nama SPJ</strong></label>
                  <input type="text" name="nama_spj" class="form-control" placeholder="Masukkan Nama SPJ" required>
              </div>
              <div class="col-md-6">
                  <label for="no_ukd" class="form-label"><strong>No UKD</strong></label>
                <input type="text" name="no_ukd" class="form-control">
              </div>
          </div>

          {{-- Keterangan --}}
          <div class="mb-4">
              <label for="keterangan" class="form-label"><strong>Keterangan</strong></label>
              <textarea name="keterangan" id="editor1" class="form-control" rows="5" placeholder="Tambahkan keterangan "></textarea>
          </div>

          {{-- Link Dokumen --}}
          <div class="form-group mb-4">
              <label for="dokumen">Link atau Upload Dokumen</label>
              <input type="text" name="dokumen" class="form-control" placeholder="https://docs.google.com/...">
              {{-- atau untuk upload file: --}}
              {{-- <input type="file" name="dokumen" class="form-control"> --}}
          </div>

          {{-- Tabel Item --}}
          <div class="table-responsive mb-3">
              <table class="table table-bordered text-center align-middle">
                  <thead class="table-light">
                      <tr>
                          <th>Item</th>
                          <th>Nominal</th>
                          <th>Status Pembayaran</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody id="spj-rows">
                      <tr>
                          <td><input type="text" name="item[]" class="form-control" required></td>
                          <td><input type="number" name="nominal[]" class="form-control nominal" required></td>
                          <td>
                              <select name="status_pembayaran[]" class="form-control" required>
                                  <option value="belum_dibayar">Belum Dibayar</option>
                                  <option value="sudah_dibayar">Sudah Dibayar</option>
                              </select>
                          </td>
                          <td><button type="button" class="btn btn-danger btn-sm remove">Hapus</button></td>
                      </tr>
                  </tbody>
              </table>
          </div>

          <div class="mb-3 text-end">
              <button type="button" class="btn btn-success" id="addRow">+ Tambah Baris</button>
          </div>

          <div class="mb-3">
              <h5>Total: <span id="total-rp">Rp 0</span></h5>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
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

    document.getElementById('addRow').addEventListener('click', function () {
        const newRow = `
            <tr>
                <td><input type="text" name="item[]" class="form-control" required></td>
                <td><input type="number" name="nominal[]" class="form-control nominal" required></td>
                <td>
                    <select name="status_pembayaran[]" class="form-control" required>
                        <option value="belum_dibayar">Belum Dibayar</option>
                        <option value="sudah_dibayar">Sudah Dibayar</option>
                    </select>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm remove">Hapus</button></td>
            </tr>
        `;
        document.getElementById('spj-rows').insertAdjacentHTML('beforeend', newRow);
        updateTotal();
    });

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('nominal')) {
            updateTotal();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove')) {
            e.target.closest('tr').remove();
            updateTotal();
        }
    });

    updateTotal();
</script>
@endsection

@push('scripts')
  <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('editor1');
  </script>
@endpush

