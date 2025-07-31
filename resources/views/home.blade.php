@extends('layout.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>

    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="small-box">
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

        <div class="col-lg-6 col-12">
            <div class="small-box">
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
</div>
@endsection
