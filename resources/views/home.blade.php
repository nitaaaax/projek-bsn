@extends('layout.app')

@section('content')
<style>
    .small-box {
        position: relative;
        display: block;
        background: #2EC6DF;
        color: #fff;
        border-radius: 10px;
        padding: 20px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .small-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .small-box .inner h3 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        color: #fff;
    }

    .small-box .inner p {
        font-size: 1.2rem;
        color: #fff;
        margin: 0;
    }

    .small-box .icon {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .small-box-footer {
        display: block;
        margin-top: 15px;
        color: #fff;
        font-weight: 500;
        text-decoration: underline;
    }

    .trivia-box {
        border-left: 6px solid #2EC6DF;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
        box-shadow: 0 5px 15px rgba(46, 198, 223, 0.08);
    }

    .trivia-text {
        max-width: 65%;
    }

    .trivia-text h5 {
        font-weight: bold;
        margin-bottom: 8px;
        color: #2EC6DF;
    }

    .trivia-text p {
        margin: 0;
        color: #333;
        font-size: 0.95rem;
        line-height: 1.4;
    }

    .trivia-img {
        max-width: 30%;
    }

    .trivia-img img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
</style>

<div class="container-fluid">
    <!-- Sapaan -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="text-dark">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-muted">Semoga harimu produktif! Yuk, cek data SPJ & UMKM hari ini.</p>
        </div>
    </div>

    <!-- Data Card -->
    <div class="row mt-2">
        <div class="col-lg-6 col-12 mb-4">
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

        <div class="col-lg-6 col-12 mb-4">
            <div class="small-box" style="background-color: #B9375D;">
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

        <!-- Fakta UMKM -->
        <div class="col-12">
            <div class="trivia-box">
                <div class="trivia-text">
                    <h5 class="fw-bold text-info">Fakta UMKM</h5>
                    <p>
                        UMKM (Usaha Mikro, Kecil, dan Menengah) memegang peran vital dalam perekonomian Indonesia
                        dengan kontribusi lebih dari <strong>60% terhadap Produk Domestik Bruto (PDB)</strong> dan
                        menyerap hampir <strong>97% tenaga kerja nasional</strong>.
                    </p>
                    <p>
                        Badan Standardisasi Nasional (BSN) hadir untuk menjembatani kebutuhan tersebut melalui penerapan
                        <strong>Standar Nasional Indonesia (SNI)</strong>, pelatihan mutu, dan sertifikasi untuk
                        meningkatkan daya saing UMKM.
                    </p>
                </div>
                <div class="trivia-img">
                    <img src="{{ asset('public/asset/dist/img/fakta-dashboard.jpg') }}" alt="Fakta UMKM">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
