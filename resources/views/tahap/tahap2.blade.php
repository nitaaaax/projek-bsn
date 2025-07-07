{{-- tahap/tahap2.blade.php --}}
<div class="mb-3">
    <label class="form-label fw-bold" for="nama_kontak">Nama Kontak</label>
    <input type="text" name="nama_kontak" class="form-control @error('nama_kontak') is-invalid @enderror" value="{{ old('nama_kontak', $data->nama_kontak ?? '') }}">
    @error('nama_kontak')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-bold" for="no_hp">No HP</label>
    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $data->no_hp ?? '') }}">
    @error('no_hp')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-bold" for="email">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $data->email ?? '') }}">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-bold" for="media_sosial">Media Sosial</label>
    <input type="text" name="media_sosial" class="form-control @error('media_sosial') is-invalid @enderror" value="{{ old('media_sosial', $data->media_sosial ?? '') }}">
    @error('media_sosial')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
