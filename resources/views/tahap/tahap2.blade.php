    <div class="row">            
            {{-- Alamat Kantor --}}
            <div class="mb-3 col-md-12">
                <label class="form-label fw-bold">Alamat Kantor</label>
                <textarea name="alamat_kantor" class="form-control">{{ old('alamat_kantor', $data->alamat_kantor ?? '') }}</textarea>
            </div>

            {{-- Provinsi & Kota Kantor --}}
            <div class="mb-3 col-md-6">
                <label class="form-label fw-bold">Provinsi Kantor</label>
                <select name="provinsi_kantor" id="provinsi_kantor" class="form-control">
                    <option value="">-- Pilih Provinsi --</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label fw-bold">Kota Kantor</label>
                <select name="kota_kantor" id="kota_kantor" class="form-control">
                    <option value="">-- Pilih Kota --</option>
                </select>
            </div>

            {{-- Alamat Pabrik --}}
            <div class="mb-3 col-md-12">
                <label class="form-label fw-bold">Alamat Pabrik</label>
                <textarea name="alamat_pabrik" class="form-control">{{ old('alamat_pabrik', $data->alamat_pabrik ?? '') }}</textarea>
            </div>

            {{-- Provinsi & Kota Pabrik --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Provinsi Pabrik</label>
                    <select name="provinsi_pabrik" id="provinsi_pabrik" class="form-control">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Kota Pabrik</label>
                    <select name="kota_pabrik" id="kota_pabrik" class="form-control">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

        {{-- Legalitas Usaha --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Legalitas Usaha</label>
            <input type="text" name="legalitas_usaha" class="form-control" value="{{ old('legalitas_usaha', $data->legalitas_usaha ?? '') }}">
        </div>

        {{-- Tahun Pendirian --}}
        <div class="mb-3 col-md-6">
            <label class="form-label fw-bold">Tahun Pendirian</label>
            <input type="number" name="tahun_pendirian" class="form-control" value="{{ old('tahun_pendirian', $data->tahun_pendirian ?? '') }}">
        </div>

        {{-- Omzet --}}
        <div class="mb-3 col-md-6">
            <label class="form-label fw-bold">Omzet per Tahun</label>
            <input type="number" name="omzet" class="form-control" value="{{ old('omzet', $data->omzet ?? '') }}">
        </div>

        {{-- Volume Produksi --}}
        <div class="mb-3 col-md-6">
            <label class="form-label fw-bold">Volume Produksi per Tahun</label>
            <input type="number" name="volume_per_tahun" class="form-control" value="{{ old('volume_per_tahun', $data->volume_per_tahun ?? '') }}">
        </div>

        {{-- Jumlah Tenaga Kerja --}}
        <div class="mb-3 col-md-6">
            <label class="form-label fw-bold">Jumlah Tenaga Kerja</label>
            <input type="number" name="jumlah_tenaga_kerja" class="form-control" value="{{ old('jumlah_tenaga_kerja', $data->jumlah_tenaga_kerja ?? '') }}">
        </div>

        {{-- Jangkauan Pemasaran --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Jangkauan Pemasaran</label>
            @php
                $opsi = ['Local', 'Nasional', 'Internasional'];
                $terpilih = old('jangkauan_pemasaran', $data->jangkauan_pemasaran ?? []);
                if (is_string($terpilih)) {
                    $terpilih = json_decode($terpilih, true) ?? [];
                }
            @endphp
            <div class="row ms-1">
                @foreach($opsi as $val)
                    <div class="col-auto">
                        <div class="form-check">
                            <input type="checkbox" name="jangkauan_pemasaran[]" value="{{ $val }}" class="form-check-input" {{ in_array($val, $terpilih) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Link Dokumen --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Link Dokumen Mutu</label>
            <input type="url" name="link_dokumen" class="form-control" value="{{ old('link_dokumen', $data->link_dokumen ?? '') }}">
        </div>

        @php
            // Gabungkan old input dengan data lama dari controller
            $instansiArray = old('instansi_detail', $instansiArray ?? []);
            $checkedArray = old('instansi_check', array_keys($instansiArray));
        @endphp
        {{-- Instansi --}}
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Instansi yang Pernah/Sedang Membina</label>
            @foreach (['Dinas', 'Kementerian', 'Perguruan Tinggi', 'Komunitas'] as $item)
                @php
                    $isChecked = in_array($item, $checkedArray);
                    $rawValue = $instansiArray[$item] ?? '';
                    $inputValue = is_array($rawValue) ? implode(', ', $rawValue) : $rawValue;
                @endphp
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="check_{{ $item }}" name="instansi_check[]" value="{{ $item }}"
                        {{ $isChecked ? 'checked' : '' }} onchange="toggleInput('{{ $item }}')">
                    <label class="form-check-label" for="check_{{ $item }}">{{ $item }}</label>
                    <input type="text" class="form-control mt-1"
                        name="instansi_detail[{{ $item }}]"
                        id="input_{{ $item }}"
                        placeholder="Isi nama {{ strtolower($item) }}"
                        value="{{ $inputValue }}"
                        style="{{ $isChecked ? '' : 'display:none;' }}">
                </div>
            @endforeach
        </div>

        {{-- sertifikat --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Sertifikat Lain yang Dimiliki</label>
            <textarea name="sertifikat" class="form-control">{{ old('sertifikat', $data->sertifikat ?? '') }}</textarea>
        </div>

        {{-- SNI yang Akan Diterapkan --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">SNI yang Akan Diterapkan</label>
            <input type="text" name="sni_yang_diterapkan" class="form-control" value="{{ old('sni_yang_diterapkan', $data->sni_yang_diterapkan ?? '') }}">
        </div>
    </div>
    
        {{-- Gruping --}}
        <div class="mb-3">
            <label for="gruping" class="form-label fw-bold">Gruping</label>
                <input type="text" name="gruping" class="form-control" value="{{ is_array(old('gruping')) ? '' : old('gruping', $data->gruping ?? '') }}" placeholder="Contoh: UMKM Pangan Lokal">
            @error('gruping')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    {{-- Foto Produk --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Foto Produk (bisa lebih dari satu)</label>
        <input type="file" name="foto_produk[]" class="form-control" multiple onchange="previewMultipleImages(this, 'preview-produk')">

    {{-- Preview Gambar Lama --}}
    <div id="old-preview-produk" class="mt-2 d-flex flex-wrap">
        @php
            $foto_produk = is_string($foto_produk) ? json_decode($foto_produk, true) : $foto_produk;
        @endphp

        @if (is_array($foto_produk) && count($foto_produk) > 0)
            @foreach ($foto_produk as $foto)
                <div class="position-relative me-2 mb-2">
                    <img src="{{ Storage::url($foto) }}" width="100" class="rounded">
                    <input type="hidden" name="old_foto_produk[]" value="{{ $foto }}">
                    <button type="button" class="btn btn-sm btn-danger p-1"
                        style="position: absolute; top: 0; right: 0;"
                        onclick="removeImage(this, 'foto_produk', '{{ $foto }}')">&times;</button>
                </div>
            @endforeach
        @else
            <p class="text-muted">Belum ada foto produk.</p>
        @endif
    </div>

    {{-- Preview Gambar Baru --}}
        <div id="preview-produk" class="mt-2 d-flex flex-wrap"></div>
    </div>

    {{-- Foto Tempat Produksi --}}
    <div class="col-md-6 mb-3">
    <label class="form-label">Foto Tempat Produksi (bisa lebih dari satu)</label>
    <input type="file" name="foto_tempat_produksi[]" class="form-control" multiple onchange="previewMultipleImages(this, 'preview-tempat')">

    {{-- Preview Gambar Lama --}}
    <div id="old-preview-tempat" class="mt-2 d-flex flex-wrap">
        @php
            $foto_tempat_produksi = is_string($foto_tempat_produksi) ? json_decode($foto_tempat_produksi, true) : $foto_tempat_produksi;
        @endphp

        @if (is_array($foto_tempat_produksi) && count($foto_tempat_produksi) > 0)
            @foreach ($foto_tempat_produksi as $foto)
                <div class="position-relative me-2 mb-2">
                    <img src="{{ Storage::url($foto) }}" width="100" class="rounded">
                    <input type="hidden" name="old_foto_tempat_produksi[]" value="{{ $foto }}">
                    <button type="button" class="btn btn-sm btn-danger p-1"
                        style="position: absolute; top: 0; right: 0;"
                        onclick="removeImage(this, 'foto_tempat_produksi', '{{ $foto }}')">&times;</button>
                </div>
            @endforeach
        @else
            <p class="text-muted">Belum ada foto tempat produksi.</p>
        @endif
    </div>

    {{-- Preview Gambar Baru --}}
        <div id="preview-tempat" class="mt-2 d-flex flex-wrap"></div>
    </div>

    {{-- Hidden field untuk gambar yang dihapus --}}
    <input type="hidden" name="removed_foto_produk" id="removed_foto_produk" value="">
    <input type="hidden" name="removed_foto_tempat_produksi" id="removed_foto_tempat_produksi" value="">


@push('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hapus gambar lama dari DOM dan form
        document.querySelectorAll('.btn-remove-old').forEach(button => {
            button.addEventListener('click', function () {
                const wrapper = this.closest('.old-foto-produk') || this.closest('.old-foto-tempat');
                wrapper.remove();
            });
        });

        // Toggle input instansi
        const checkboxes = document.querySelectorAll('.form-check-input[type="checkbox"][name="instansi_check[]"]');

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const inputId = 'input_' + this.value;
                const textInput = document.getElementById(inputId);
                if (this.checked) {
                    textInput.style.display = 'block';
                } else {
                    textInput.style.display = 'none';
                    textInput.value = '';
                }
            });
        });
    });
    </script>

    <script>
    function removeImage(button, fieldName, fileName) {
        // Hapus elemen preview-nya
        button.closest('.position-relative').remove();

        // Ambil input hidden
        let input = document.getElementById(`removed_${fieldName}`);
        if (input) {
            let current = input.value ? input.value.split(',') : [];
            current.push(fileName.split('/').pop()); // hanya ambil nama file-nya
            input.value = current.join(',');
        }
    }
    </script>

    <script>
    $(document).ready(function () {
        // Ambil semua provinsi saat halaman siap
        $.get("{{ url('admin/umkm-proses/get-provinsi') }}", function (data) {
            console.log('Data provinsi:', data); // Debugging
            $.each(data, function (index, provinsi) {
                $('#provinsi_kantor, #provinsi_pabrik').append(`<option value="${provinsi.id}">${provinsi.nama}</option>`);
            });
        }).fail(function(xhr, status, error) {
            console.error('Gagal ambil provinsi:', xhr.responseText);
        });

        // Event saat provinsi kantor berubah
        $('#provinsi_kantor').on('change', function () {
            const id = $(this).val();
            $('#kota_kantor').empty().append('<option value="">-- Pilih Kota --</option>');
            if (id) {
                $.get(`{{ url('admin/umkm-proses/get-kota') }}/${id}`, function (data) {
                    $.each(data, function (index, kota) {
                        $('#kota_kantor').append(`<option value="${kota.id}">${kota.nama}</option>`);
                    });
                }).fail(function(xhr, status, error) {
                    console.error('Gagal ambil kota kantor:', xhr.responseText);
                });
            }
        });

        // Event saat provinsi pabrik berubah
        $('#provinsi_pabrik').on('change', function () {
            const id = $(this).val();
            $('#kota_pabrik').empty().append('<option value="">-- Pilih Kota --</option>');
            if (id) {
                $.get(`{{ url('admin/umkm-proses/get-kota') }}/${id}`, function (data) {
                    $.each(data, function (index, kota) {
                        $('#kota_pabrik').append(`<option value="${kota.id}">${kota.nama}</option>`);
                    });
                }).fail(function(xhr, status, error) {
                    console.error('Gagal ambil kota pabrik:', xhr.responseText);
                });
            }
        });
    });
    </script>

    <script>
    function previewMultipleImages(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';

        Array.from(input.files).forEach((file) => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'd-inline-block position-relative me-2 mb-2';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '100px';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
                btn.innerHTML = '&times;';
                btn.style.zIndex = 5;
                btn.onclick = () => wrapper.remove();

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                preview.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    }

    function removeImage(button, fieldType, imagePath) {
        const hiddenField = document.getElementById(`removed_${fieldType}`);
        let removedImages = [];

        try {
            removedImages = hiddenField.value ? JSON.parse(hiddenField.value) : [];
        } catch {
            removedImages = [];
        }

        removedImages.push(imagePath);
        hiddenField.value = JSON.stringify(removedImages);

        button.parentElement.remove();
    }
    </script>
    
    <script>
    function previewMultipleImages(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';

        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'd-inline-block position-relative me-2 mb-2';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '100px';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
                btn.style.zIndex = 5;
                btn.innerHTML = '&times;';
                btn.onclick = () => wrapper.remove(); // Just remove preview

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                preview.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    }

    function removeImage(button, fieldType, imagePath) {
        const hiddenField = document.getElementById(`removed_${fieldType}`);
        let removedImages = [];

        try {
            removedImages = hiddenField.value ? JSON.parse(hiddenField.value) : [];
        } catch (e) {
            removedImages = [];
        }

        removedImages.push(imagePath);
        hiddenField.value = JSON.stringify(removedImages);

        button.parentElement.remove();
    }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const instansi = ['dinas', 'kementerian', 'pt', 'komunitas'];

            instansi.forEach(function (item) {
                const checkbox = document.getElementById('check_' + item);
                const inputBox = document.getElementById('input_' + item);

                checkbox.addEventListener('change', function () {
                    if (checkbox.checked) {
                        inputBox.style.display = 'block';
                    } else {
                        inputBox.style.display = 'none';
                        inputBox.value = '';
                    }
                });
            });
        });
    </script>

    <script>
    function toggleInput(key) {
        var checkbox = document.getElementById("check_" + key);
        var input = document.getElementById("input_" + key);
        input.style.display = checkbox.checked ? "block" : "none";
    }
    </script>

@endpush
