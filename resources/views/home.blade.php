@extends('layout.app')

@section('content')
<style>
    .small-box {
        position: relative;
        display: block;
        background: linear-gradient(135deg, #1FB2C9, #2EC6DF);
        color: #fff;
        border-radius: 16px;
        padding: 25px;
        overflow: hidden;
        transition: 0.3s ease;
    }

    .small-box:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .small-box .inner h3 {
        font-size: 2.4rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .small-box .inner p {
        font-size: 1.15rem;
        margin: 0;
    }

    .small-box .icon {
        position: absolute;
        top: 20px;
        right: 25px;
        font-size: 3.2rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .small-box-footer {
        display: block;
        margin-top: 15px;
        color: #fff;
        font-weight: 500;
        text-decoration: underline;
    }

    .motivasi-box {
        border-left: 6px solid #00BFA6;
        background-color: #f1fdfc;
        padding: 25px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 30px;
        box-shadow: 0 6px 20px rgba(0, 191, 166, 0.1);
    }

    .motivasi-text {
        max-width: 65%;
    }

    .motivasi-text h5 {
        font-weight: bold;
        margin-bottom: 12px;
        color: #00BFA6;
    }

    .motivasi-text p {
        margin: 0;
        color: #333;
        font-size: 1rem;
        line-height: 1.5;
    }

    .motivasi-img {
        max-width: 30%;
    }

    .motivasi-img img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }
</style>

<div class="container-fluid">
    <!-- Sapaan -->
    <div class="row mb-3">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4 px-4 py-3" style="background: linear-gradient(90deg, #f0f8ff, #ffffff);">
            <div class="d-flex align-items-center gap-3">
                <div class="text-primary">
                    <i class="fas fa-seedling fa-2x"></i>
                </div>
                <div>
                    <h5 class="mb-1 fw-semibold text-dark">
                        Hai, {{ Auth::user()->username }}! 👋
                    </h5>
                    <p class="mb-1 text-muted small">
                        {{ Auth::user()->email }}
                    </p>

                    <p class="mb-0 text-muted small">
                        Semangat hari ini! Setiap langkah kecil adalah kemajuan besar ke depan 💪
                    </p>
                </div>
            </div>
        </div>
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
            <div class="small-box" style="background: linear-gradient(135deg, #b92151ff, #B9375D);">
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
