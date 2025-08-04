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

      {{-- Instansi --}}
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Instansi yang Pernah/Sedang Membina</label>
        @foreach (['Dinas', 'Kementerian', 'Perguruan Tinggi', 'Komunitas'] as $item)
            @php
                $isChecked = old('instansi_check') && in_array($item, old('instansi_check', []));
                $inputValue = old("instansi_detail.$item", '');
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
                    {{ $isChecked ? '' : 'style=display:none;' }}>
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
        <input type="text" name="gruping" class="form-control" value="{{ old('gruping') }}" placeholder="Contoh: UMKM Pangan Lokal">
        @error('gruping')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    {{-- Preview Foto Produk Lama --}}
    <div class="d-flex flex-wrap mt-2">
        @foreach ($foto_produk as $foto)
            <div class="me-2 mb-2 position-relative">
                <img src="{{ asset('storage/uploads/gambar_produk' . $foto) }}" width="100" class="rounded">
            </div>
        @endforeach
    </div>

    {{-- Preview Foto Tempat Produksi Lama --}}
    <div class="d-flex flex-wrap mt-2">
        @foreach ($foto_tempat_produksi as $foto)
            <div class="me-2 mb-2 position-relative">
                <img src="{{ asset('storage/uploads/gambar_tempat_produksi' . $foto) }}" width="100" class="rounded">
            </div>
        @endforeach
    </div>


    <!-- Hidden fields to track removed images -->
    <input type="hidden" name="removed_foto_produk" id="removed_foto_produk" value="">
    <input type="hidden" name="removed_foto_tempat_produksi" id="removed_foto_tempat_produksi" value="">

    @push('scripts')
    <!-- Jquery CDN (cukup satu kali saja) -->
    <script>
        const dataWilayah = {
            "Riau": [
                "Pekanbaru", "Dumai", "Bengkalis", "Siak", "Kampar", "Pelalawan", "Indragiri Hulu", "Indragiri Hilir", "Rokan Hulu", "Rokan Hilir"
            ],
            "Sumatra Barat": [
                "Padang", "Bukittinggi", "Payakumbuh", "Solok", "Pariaman", "Sawahlunto", "Padang Panjang", "Pasaman", "Agam", "Tanah Datar"
            ]
        };

        function populateSelect(selectId, options, selected = "") {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">-- Pilih --</option>';
            options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option;
                opt.text = option;
                if (option === selected) opt.selected = true;
                select.appendChild(opt);
            });
        }

        // Populate provinsi
        window.onload = function () {
            const provinsiList = Object.keys(dataWilayah);
            populateSelect("provinsi_kantor", provinsiList, "{{ old('provinsi_kantor', $data->provinsi_kantor ?? '') }}");
            populateSelect("provinsi_pabrik", provinsiList, "{{ old('provinsi_pabrik', $data->provinsi_pabrik ?? '') }}");

            // Populate kota default jika sudah ada
            if ("{{ old('provinsi_kantor', $data->provinsi_kantor ?? '') }}") {
                populateSelect("kota_kantor", dataWilayah["{{ old('provinsi_kantor', $data->provinsi_kantor ?? '') }}"], "{{ old('kota_kantor', $data->kota_kantor ?? '') }}");
            }
            if ("{{ old('provinsi_pabrik', $data->provinsi_pabrik ?? '') }}") {
                populateSelect("kota_pabrik", dataWilayah["{{ old('provinsi_pabrik', $data->provinsi_pabrik ?? '') }}"], "{{ old('kota_pabrik', $data->kota_pabrik ?? '') }}");
            }
        };

        // Provinsi kantor onchange
        document.getElementById('provinsi_kantor').addEventListener('change', function () {
            const selectedProv = this.value;
            const kotaList = dataWilayah[selectedProv] || [];
            populateSelect("kota_kantor", kotaList);
        });

        // Provinsi pabrik onchange
        document.getElementById('provinsi_pabrik').addEventListener('change', function () {
            const selectedProv = this.value;
            const kotaList = dataWilayah[selectedProv] || [];
            populateSelect("kota_pabrik", kotaList);
        });
    </script>

    <script>
    function previewMultipleImages(input, containerId) {
        const container = document.getElementById(containerId);
        const files = input.files;
        container.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.style.position = 'relative';
                wrapper.style.display = 'inline-block';
                wrapper.style.width = '150px';
                wrapper.style.marginRight = '10px';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '100%';

                const btnRemove = document.createElement('button');
                btnRemove.type = 'button';
                btnRemove.innerText = '❌';
                btnRemove.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
                btnRemove.style.zIndex = '5';
                btnRemove.style.position = 'absolute';
                btnRemove.style.top = '2px';
                btnRemove.style.right = '2px';

                btnRemove.onclick = () => wrapper.remove();

                wrapper.appendChild(img);
                wrapper.appendChild(btnRemove);
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(files[i]);
        }
    }

    function removeImage(button, fieldType, imagePath) {
        // Add to removed images list
        const hiddenField = document.getElementById(`removed_${fieldType}`);
        const removedImages = hiddenField.value ? JSON.parse(hiddenField.value) : [];
        removedImages.push(imagePath);
        hiddenField.value = JSON.stringify(removedImages);
        
        // Remove from display
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

    <!--INstansi yang pernah membina-->
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
