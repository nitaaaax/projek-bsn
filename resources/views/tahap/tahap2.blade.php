    <div class="row">
        <input type="hidden" name="pelaku_usaha_id" value="{{ $data->pelaku_usaha_id ?? '' }}">

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
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Instansi yang Pernah/Sedang Membina</label>
            <textarea name="instansi" class="form-control">{{ old('instansi', $data->instansi ?? '') }}</textarea>
        </div>

        {{-- Sertifikat --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Sertifikat</label>
            <textarea name="sertifikat" class="form-control">{{ old('sertifikat', $data->sertifikat ?? '') }}</textarea>
        </div>

        {{-- SNI yang Akan Diterapkan --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">SNI yang Akan Diterapkan</label>
            <input type="text" name="sni_yang_diterapkan" class="form-control" value="{{ old('sni_yang_diterapkan', $data->sni_yang_diterapkan ?? '') }}">
        </div>
    </div>
    
        {{-- Upload Foto Produk --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Foto Produk</label>
            <input type="file" name="foto_produk[]" multiple class="form-control" accept="image/jpeg,image/png,image/jpg" onchange="previewMultipleImages(this, 'previewFotoProduk')">

            <small class="text-muted">Format: JPEG, PNG, JPG (Max 2MB per file)</small>

            {{-- Preview New Images --}}
            <div id="previewFotoProduk" class="mt-2"></div>

            {{-- Preview Existing Images --}}
            @if (!empty($data->foto_produk))
                <div class="mt-2">
                    @foreach (json_decode($data->foto_produk, true) ?? [] as $img)
                        <div class="d-inline-block position-relative me-2 mb-2">
                            <img src="{{ asset('storage/'.$img) }}" alt="" width="100" class="img-thumbnail">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="removeImage(this, 'foto_produk', '{{ $img }}')">
                                &times;
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Upload Foto Tempat Produksi --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Foto Tempat Produksi</label>
            <input type="file" name="foto_tempat_produksi[]" multiple class="form-control" accept="image/jpeg,image/png,image/jpg" onchange="previewMultipleImages(this, 'previewTempatProduksi')">

            <small class="text-muted">Format: JPEG, PNG, JPG (Max 2MB per file)</small>

            {{-- Preview New Images --}}
            <div id="previewTempatProduksi" class="mt-2"></div>

            {{-- Preview Existing Images --}}
            @if (!empty($data->foto_tempat_produksi))
                <div class="mt-2">
                    @foreach (json_decode($data->foto_tempat_produksi, true) ?? [] as $img)
                        <div class="d-inline-block position-relative me-2 mb-2">
                            <img src="{{ asset('storage/'.$img) }}" alt="" width="100" class="img-thumbnail">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="removeImage(this, 'foto_tempat_produksi', '{{ $img }}')">
                                &times;
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
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
    
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.width = 100;
                img.className = 'img-thumbnail me-2 mb-2';
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
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
    @endpush
