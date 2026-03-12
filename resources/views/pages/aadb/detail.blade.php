@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 mt-3">
            <div class="col-sm-12">
                <h3 class="m-0 font-weight-bold text-dark">Detail Kendaraan</h3>
                <ol class="breadcrumb mt-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('aadb') }}">Daftar AADB</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card custom-card-bbm shadow-sm p-3">
                    <div class="text-center position-relative mb-4">
                        @php
                            $status_class = ($data->status == 'true') ? 'badge-success' : 'badge-danger';
                            $status_text = ($data->status == 'true') ? 'Aktif' : 'Tidak Aktif';
                        @endphp
                        <span class="badge {{ $status_class }} position-absolute shadow-sm" style="top: 10px; right: 10px; padding: 8px 15px; border-radius: 50px;">
                            <i class="fas {{ ($data->status == 'true') ? 'fa-check-circle' : 'fa-times-circle' }}"></i> {{ $status_text }}
                        </span>

                        @if ($data->foto_barang)
                            <img src="{{ asset('dist/img/foto_aadb/'. $data->foto_barang) }}" class="rounded img-fluid border shadow-sm" style="max-height: 250px; width: 100%; object-fit: cover;">
                        @else
                            <img src="https://cdn-icons-png.flaticon.com/128/7571/7571054.png" class="p-4 opacity-50" style="width: 150px;">
                        @endif
                    </div>

                    <div class="px-2">
                        <h5 class="text-primary font-weight-bold mb-1">{{ $data->no_polisi }}</h5>
                        <h4 class="font-weight-bold mb-4">{{ $data->merk_tipe }}</h4>

                        <div class="detail-info">
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <span class="text-muted">Kategori</span>
                                <span class="font-weight-bold text-capitalize">{{ $data->kategori->nama_kategori }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <span class="text-muted">Kondisi</span>
                                <span class="badge badge-pill {{ $data->kondisi->nama_kondisi == 'Baik' ? 'badge-light text-success' : 'badge-light text-warning' }} px-3 border">
                                    {{ $data->kondisi->nama_kondisi }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <span class="text-muted">No. BPKB</span>
                                <span class="text-dark">{{ $data->no_bpkb }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <span class="text-muted">Tahun Perolehan</span>
                                <span class="text-dark">{{ $data->tanggal_perolehan }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <span class="text-muted">Nilai Perolehan</span>
                                <span class="text-dark">Rp {{ number_format($data->nilai_perolehan, 0, ',', '.') }}</span>
                            </div>
                            <div class="mb-4">
                                <span class="text-muted d-block mb-1">Unit Kerja Asal:</span>
                                <p class="small font-weight-bold text-secondary bg-light p-2 rounded border">{{ $data->uker->unit_kerja }}</p>
                            </div>
                        </div>

                        <a href="{{ route('aadb.edit', $data->id_aadb) }}" class="btn btn-warning btn-block shadow-sm font-weight-bold">
                            <i class="fas fa-edit mr-1"></i> Edit Data Kendaraan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card p-3 shadow-sm rounded bg-white border-left border-secondary">
                            <small class="text-muted text-uppercase font-weight-bold">Permintaan</small>
                            <h4 class="mb-0 font-weight-bold mt-1">0</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card p-3 shadow-sm rounded bg-white border-left border-success">
                            <small class="text-muted text-uppercase font-weight-bold">Alokasi</small>
                            <h4 class="mb-0 font-weight-bold text-success mt-1">Rp 0</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card p-3 shadow-sm rounded bg-white border-left border-primary">
                            <small class="text-muted text-uppercase font-weight-bold">Realisasi</small>
                            <h4 class="mb-0 font-weight-bold text-primary mt-1">Rp 0</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card p-3 shadow-sm rounded bg-white border-left border-danger">
                            <small class="text-muted text-uppercase font-weight-bold">Sisa</small>
                            <h4 class="mb-0 font-weight-bold text-danger mt-1">Rp 0</h4>
                        </div>
                    </div>
                </div>

                <div class="card custom-card-bbm shadow-sm">
                    <div class="card-header-bbm p-3 d-flex align-items-center">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-history mr-2 text-muted"></i> Riwayat Penggunaan Anggaran</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern m-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4" style="width: 50px;">No</th>
                                        <th class="py-3">Deskripsi Pekerjaan / BBM</th>
                                        <th class="py-3 text-right px-4">Nilai (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            <img src="https://cdn-icons-png.flaticon.com/128/11329/11329060.png" style="width: 60px; opacity: 0.3;" class="mb-3 d-block mx-auto">
                                            Belum ada riwayat transaksi untuk kendaraan ini.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $("#uker").select2()
    $("#table").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "info": true,
        "paging": true,
        "searching": true,
        buttons: [{
            extend: 'pdf',
            text: ' PDF',
            pageSize: 'A4',
            className: 'bg-danger',
            title: 'Pegawai',
            exportOptions: {
                columns: [0, 2, 3, 4],
            },
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success',
            title: 'Pegawai',
            exportOptions: {
                columns: ':not(:nth-child(2))'
            },
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
