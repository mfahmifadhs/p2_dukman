@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8 mt-5">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Usulan</li>
                </ol>
                <h2 class="font-weight-bold text-dark">Buat Usulan Baru</h2>
                <p class="text-muted">Pilih kategori layanan kendaraan yang Anda butuhkan saat ini.</p>
            </div>
        </div>
    </div>
</div>


<style>
    /* Membuat shadow lebih halus dan transisi smooth */
    .option-card {
        border: none !important;
        border-radius: 12px !important;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
    }

    .option-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }

    /* Mengatur lebar ikon agar tidak terlalu dominan tapi tetap proporsional */
    .icon-section {
        min-width: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Memperluas jarak antar baris teks */
    .content-section {
        padding: 1.5rem 2rem !important;
        /* Membuat kesan 'luas' */
    }

    .text-title {
        font-size: 1.2rem;
        letter-spacing: 0.3px;
    }
</style>

<section class="content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">

                <a href="{{ route('usulan.create', 'servis') }}" class="text-decoration-none text-dark">
                    <div class="card option-card shadow-sm mb-4">
                        <div class="d-flex border-left border-info" style="border-left-width: 6px !important;">
                            <div class="icon-section bg-light text-info">
                                <i class="fas fa-tools fa-2x"></i>
                            </div>
                            <div class="content-section flex-grow-1 bg-white">
                                <h5 class="font-weight-bold text-title mb-1">Usulan Pemeliharaan</h5>
                                <p class="text-muted mb-0 small">Input kerusakan dan perbaikan kendaraan (Lampirkan PDF foto kerusakan).</p>
                            </div>
                            <div class="d-flex align-items-center pr-4 bg-white text-muted">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('usulan.create', 'bbm') }}" class="text-decoration-none text-dark">
                    <div class="card option-card shadow-sm mb-4">
                        <div class="d-flex border-left border-success" style="border-left-width: 6px !important;">
                            <div class="icon-section bg-light text-success">
                                <i class="fas fa-gas-pump fa-2x"></i>
                            </div>
                            <div class="content-section flex-grow-1 bg-white">
                                <h5 class="font-weight-bold text-title mb-1 text-success">Usulan BBM</h5>
                                <p class="text-muted mb-0 small">Pengajuan bahan bakar bulanan (Maksimal tanggal 20 setiap bulan).</p>
                            </div>
                            <div class="d-flex align-items-center pr-4 bg-white text-muted">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('usulan.create', 'pinjam') }}" class="text-decoration-none text-dark">
                    <div class="card option-card shadow-sm mb-4">
                        <div class="d-flex border-left border-warning" style="border-left-width: 6px !important;">
                            <div class="icon-section bg-light text-warning">
                                <i class="fas fa-car fa-2x"></i>
                            </div>
                            <div class="content-section flex-grow-1 bg-white">
                                <h5 class="font-weight-bold text-title mb-1 text-warning">Peminjaman Kendaraan</h5>
                                <p class="text-muted mb-0 small">Reservasi kendaraan operasional untuk keperluan dinas.</p>
                            </div>
                            <div class="d-flex align-items-center pr-4 bg-white text-muted">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</section>
@endsection