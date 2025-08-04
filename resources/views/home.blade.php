@extends('layout.app')

@section('content')
<style>
    .small-box {
        position: relative;
        display: block;
        background: #fff;
        border: 3px solid #2EC6DF;
        border-radius: 10px;
        padding: 20px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .small-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(46, 198, 223, 0.25);
    }

    .small-box .inner h3 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        color: #2EC6DF;
    }

    .small-box .inner p {
        font-size: 1.2rem;
        color: #333;
        margin: 0;
    }

    .small-box .icon {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 3rem;
        color: #B9375D;
        opacity: 0.3;
    }

    .small-box-footer {
        display: block;
        margin-top: 15px;
        color: #2EC6DF;
        font-weight: 500;
        text-decoration: none;
    }

    .small-box-footer:hover {
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
    <h1 class="mt-4">Dashboard</h1>

    <div class="row mt-4">
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
    <div class="col-12">
        <div class="trivia-box d-flex align-items-center p-4" style="background: #f8fcfd; border-left: 5px solid #2EC6DF; border-radius: 10px;">
            <div class="flex-grow-1 pe-4">
                <h5 class="fw-bold text-info">Fakta UMKM</h5>
                <p>
                    UMKM (Usaha Mikro, Kecil, dan Menengah) memegang peran vital dalam perekonomian Indonesia dengan kontribusi lebih dari <strong>60% terhadap Produk Domestik Bruto (PDB)</strong> dan menyerap hampir <strong>97% tenaga kerja nasional</strong>. Namun, tantangan besar masih dihadapi UMKM untuk bersaing di pasar global, seperti keterbatasan akses terhadap pembiayaan, teknologi, serta rendahnya kualitas produk yang belum memenuhi standar nasional maupun internasional.
                </p>
                <p class="mb-0">
                    Badan Standardisasi Nasional (BSN) hadir untuk menjembatani kebutuhan tersebut melalui penerapan <strong>Standar Nasional Indonesia (SNI)</strong>, pelatihan peningkatan mutu, serta program sertifikasi yang dapat diakses UMKM secara bertahap. Dengan mengadopsi standar, UMKM tidak hanya meningkatkan daya saing tetapi juga membuka peluang untuk ekspor, memperluas jangkauan pasar, dan meningkatkan kepercayaan konsumen. Langkah kecil menuju standardisasi adalah lompatan besar menuju keberlanjutan usaha!
                </p>
            </div>
            <div class="flex-shrink-0">
                <img src="{{ asset('public/asset/dist/img/fakta-dashboard.jpg') }}" alt="Fakta UMKM" style="max-width: 700px;">
            </div>
        </div>
    </div>

    </div>
        </div>

        </div>
    </div>
</div>
@endsection
