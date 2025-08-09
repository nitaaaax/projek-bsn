@extends('layout.app')

@section('content')
<style>
    /* Step Navigation */
    .step-nav {
        display: flex;
        width: 100%;
        margin-bottom: 10px;
        border-radius: 8px;
        overflow: hidden;
    }
    .step-btn {
        flex: 1;
        padding: 12px;
        border: none;
        background-color: #f1f1f1;
        cursor: pointer;
        font-weight: 500;
        text-align: center;
        transition: all 0.3s ease;
    }
    .step-btn.active {
        background-color: #007bff;
        color: white;
    }

    /* Progress Bar */
    .progress-container {
        width: 100%;
        height: 6px;
        background-color: #e0e0e0;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .progress-bar {
        height: 100%;
        background-color: #007bff;
        width: 0%;
        transition: width 0.3s ease;
    }

    /* Step Form */
    .form-step {
        display: none;
        animation: fadeIn 0.4s ease-in-out;
    }
    .form-step.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid">
    <div class="card p-4 shadow-sm">
        <h4 class="mb-3">{{ isset($id) ? 'Edit' : 'Tambah' }} Data UMKM</h4>

        {{-- Step Navigation --}}
        <div class="step-nav">
            <button type="button" class="step-btn" data-step="1">Tahap 1</button>
            <button type="button" class="step-btn" data-step="2">Tahap 2</button>
        </div>

        {{-- Progress Bar --}}
        <div class="progress-container">
            <div class="progress-bar" id="progress-bar"></div>
        </div>

        <form 
            action="{{ isset($id) ? route('admin.umkm.store', $id) : route('admin.umkm.store') }}"
            method="POST" enctype="multipart/form-data">

            @csrf
            @if(isset($id)) @method('PUT') @endif
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">

            {{-- Step 1 --}}
            <div class="form-step" id="step-1">
                @includeIf('tahap.partials.tahap1', ['data' => $data ?? null])

                <div class="mt-4 text-end">
                    <button type="button" class="btn btn-primary px-4" id="btn-next">
                        Lanjut →
                    </button>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="form-step" id="step-2">
                @includeIf('tahap.partials.tahap2', ['data' => $data ?? null])

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4 py-2">
                         Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Script Step Form --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const stepButtons = document.querySelectorAll(".step-btn");
    const steps = document.querySelectorAll(".form-step");
    const progressBar = document.getElementById("progress-bar");

    function showStep(step) {
        steps.forEach(s => s.classList.remove("active"));
        document.getElementById(`step-${step}`).classList.add("active");

        stepButtons.forEach(b => b.classList.remove("active"));
        document.querySelector(`.step-btn[data-step="${step}"]`).classList.add("active");

        progressBar.style.width = step === "1" ? "50%" : "100%";
    }

    stepButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            showStep(this.dataset.step);
        });
    });

    // Next button in Step 1
    document.getElementById("btn-next").addEventListener("click", function() {
        showStep("2");
    });

    // Default buka Tahap 1
    showStep("1");
});
</script>
@endsection
