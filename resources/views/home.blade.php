@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Greeting Section --}}
    <div class="card shadow-lg border-0 rounded-4 mb-4 position-relative" 
     style="background: linear-gradient(135deg, rgba(67, 67, 185, 0.72), rgba(176, 105, 243, 0.43)); color: white;">
    <div class="card-body">
        <h4 class="fw-bold mb-1">Halo, {{ Auth::user()->username }} 👋</h4>
        <p class="mb-2">{{ Auth::user()->email }}</p>
        <span class="badge px-3 py-2 rounded-pill fw-semibold" 
              style="background: rgba(255,255,255,0.2); font-size: 0.85rem;">
            <i class="fas fa-user-shield me-1"></i> {{ Auth::user()->role->name }}
        </span>

        <!-- Foto pojok kanan -->
        <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center position-absolute" 
             style="width: 80px; height: 80px; background-color: #f8f9fa; top: 15px; right: 15px;">
            <i class="fas fa-user" style="font-size: 40px; color: #6c757d;"></i>
        </div>
    </div>
</div>


    {{-- Statistik Cards --}}
    <style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    .card-blue {
        background: linear-gradient(135deg, #3b82f6, #1e3a8a);
    }
    .card-pink {
        background: linear-gradient(135deg, #ec4899, #9d174d);
    }
    .stat-card .icon {
        font-size: 5rem;
        opacity: 0.1;
        pointer-events: none;
    }
</style>

<div class="row g-4">
    <!-- SPJ -->
    <div class="col-lg-6 col-md-6 col-12">
        <a href="{{ route('spj.index') }}" class="text-decoration-none">
            <div class="card stat-card card-blue rounded-4 shadow-sm h-100 text-white position-relative p-4">
                <div class="icon position-absolute top-0 end-0 p-3">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $jumlahSpj }}</h3>
                <p class="mb-2">Jumlah SPJ</p>
                <div class="fw-semibold mt-3">Lihat Semua <i class="fas fa-arrow-right"></i></div>
            </div>
        </a>
    </div>

    <!-- UMKM -->
    <div class="col-lg-6 col-md-6 col-12">
        <a href="{{ route('umkm.proses.index') }}" class="text-decoration-none">
            <div class="card stat-card card-pink rounded-4 shadow-sm h-100 text-white position-relative p-4">
                <div class="icon position-absolute top-0 end-0 p-3">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $jumlahUmkm }}</h3>
                <p class="mb-2">Jumlah UMKM</p>
                <div class="fw-semibold mt-3">Lihat Semua <i class="fas fa-arrow-right"></i></div>
            </div>
        </a>
    </div>
</div>


    {{-- Motivasi --}}
    <div class="card mt-4 border-0 rounded-4 shadow-sm p-4" style="background: #f8fafc;">
        <h5 class="fw-bold mb-2">💡 Daily Hype</h5>
        <p class="mb-0 text-muted">
        Don’t stop when you’re tired, stop when you’re done.        </p>
    </div>

</div>

<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }
    .icon {
        pointer-events: none;
    }
    a.text-decoration-none:hover {
        text-decoration: none !important;
    }
    .card-blue {
        background: linear-gradient(135deg, #2476bdff, rgba(66, 186, 192, 1));
    }
    .card-pink {
        background: linear-gradient(135deg, rgba(172, 41, 41, 1), rgba(211, 77, 77, 1));
    }
</style>
@endsection
