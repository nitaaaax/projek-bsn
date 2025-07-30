@extends('layout.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    
    {{-- Cek apakah user adalah admin --}}
    @if (Auth::user()->role === 'admin')
      {{-- Konten untuk Admin --}}
      <div class="row">
        <!-- Box 1 - SPJ -->
        <div class="col-lg-6 col-12">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $jumlahSpj }}</h3>
              <p>Jumlah SPJ</p>
            </div>
            <div class="icon">
              <i class="fas fa-file-alt"></i>
            </div>
            <a href="{{ route('spj.index') }}" class="small-box-footer">
              Lihat Semua <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Box 2 - UMKM -->
        <div class="col-lg-6 col-12">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $jumlahUmkm }}</h3>
              <p>Jumlah UMKM</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('umkm.proses.index') }}" class="small-box-footer">
              Lihat Semua <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>

    @else
      {{-- Konten untuk User --}}
      <div class="alert alert-info">
        <h5>Selamat datang {{ Auth::user()->name }}!</h5>
        <p>Silakan lihat data UMKM atau Transaksi yang tersedia.</p>
      </div>

      <div class="row">
        <!-- Box - UMKM (tanpa akses CRUD) -->
        <div class="col-lg-6 col-12">
          <div class="small-box bg-success">
            <div class="inner">
              <h4>Data UMKM</h4>
              <p>Informasi UMKM yang bisa dilihat</p>
            </div>
            <div class="icon">
              <i class="fas fa-eye"></i>
            </div>
            <a href="{{ route('umkm.proses.index') }}" class="small-box-footer">
              Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    @endif

  </div>
</section>
@endsection
