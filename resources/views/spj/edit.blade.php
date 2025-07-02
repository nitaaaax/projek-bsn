@extends('layout.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit SPJ</h2>

    <form action="{{ route('spj.update', $spj->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_spj" class="form-label">Nama SPJ</label>
            <input type="text" name="nama_spj" class="form-control" value="{{ $spj->nama_spj }}" required>
        </div>

        <h5>Daftar Item</h5>
        <div id="items">
            @foreach ($spj->details as $i => $detail)
                <div class="row mb-3 item-row align-items-start">
                    <div class="col-md-3">
                        <input type="text" name="item[]" class="form-control" placeholder="Item" value="{{ $detail->item }}" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="nominal[]" class="form-control nominal" placeholder="Nominal (Rp)" value="{{ $detail->nominal }}" required>
                    </div>
                    <div class="col-md-2">
                        <select name="pembayaran[]" class="form-control" required>
                            <option value="belum_dibayar" {{ $detail->status_pembayaran == 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="sudah_dibayar" {{ $detail->status_pembayaran == 'sudah_dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <textarea name="keterangan[]" class="form-control" placeholder="Keterangan">{{ $detail->keterangan }}</textarea>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-item">X</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-success mb-3" id="add-item">+ Tambah Item</button>

        <div class="mb-3">
            <h5>Total: <span id="total-rp">Rp 0</span></h5>
        </div>

        <button type="submit" class="btn btn-primary">Update SPJ</button>
    </form>
</div>

<script>
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.nominal').forEach(input => {
            total += parseInt(input.value) || 0;
        });
        document.getElementById('total-rp').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('items');
        const row = document.createElement('div');
        row.classList.add('row', 'mb-3', 'item-row', 'align-items-start');
        row.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="item[]" class="form-control" placeholder="Item" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="nominal[]" class="form-control nominal" placeholder="Nominal (Rp)" required>
            </div>
            <div class="col-md-2">
                <select name="pembayaran[]" class="form-control" required>
                    <option value="belum_dibayar">Belum Dibayar</option>
                    <option value="sudah_dibayar">Sudah Dibayar</option>
                </select>
            </div>
            <div class="col-md-4">
                <textarea name="keterangan[]" class="form-control" placeholder="Keterangan"></textarea>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-item">X</button>
            </div>
        `;
        container.appendChild(row);
        updateTotal();
    });

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('nominal')) {
            updateTotal();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
            updateTotal();
        }
    });

    updateTotal();
</script>
@endsection
