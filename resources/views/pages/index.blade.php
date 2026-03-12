@extends('layouts.app')

@section('content')

<!-- Main content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="font-weight-bold mb-4 text-capitalize">
                            Selamat Datang, {{ ucfirst(strtolower(Auth::user()->pegawai->nama_pegawai)) }}
                            <small>({{ Auth::user()->pegawai->uker->unit_kerja }})</small>
                        </h4>
                    </div>

                    <div class="col-md-3">

                        <div class="form-group">
                            <div class="info-box mb-3 border border-dark" style="background-color: #4ed59a;">
                                <span class="info-box-icon"><i class="fas fa-pencil"></i></span>

                                <div class="info-box-content">
                                    <h3 class="info-box-number">{{ $usulan->where('form_id', 3)->count() }}</h3>
                                    <h6 class="info-box-text text-sm">Usulan Alat Tulis Kantor</h6>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="card card-widget widget-user-2 border border-dark">
                                    <div class="bg-primary p-3">
                                        <h6 class="my-auto font-weight-bold">
                                            <i class="fas fa-pencil-ruler"></i> Usulan ATK
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="nav flex-column font-weight-bold">
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="status" value="verif">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-file-signature"></i> Persetujuan
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 3)->whereNull('status_persetujuan')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="status" value="proses">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-clock"></i> Proses
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 3)->where('status_proses', 'proses')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-check-circle"></i> Selesai
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 3)->where('status_proses', 'selesai')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <form action="{{ route('usulan', 'atk') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="status" value="false">
                                                    <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block">
                                                        <span class="float-left">
                                                            <i class="fas fa-times-circle"></i> Ditolak
                                                        </span>
                                                        <span class="float-right">
                                                            {{ $usulan->where('form_id', 3)->where('status_persetujuan', 'false')->count() }}
                                                            usulan
                                                        </span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <!-- Usulan -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border border-dark">
                                    <div class="card-body">
                                        <label for="stok">Stok Persediaan ATK</label>
                                        <table id="table-data" class="table table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Barang</th>
                                                    <th>Stok</th>
                                                    <th>Permintaan</th>
                                                    <th>Sisa Stok</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($atk as $row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $row->nama_barang }}</td>
                                                    <td>{{ $row->stokMasuk->sum('jumlah') }}</td>
                                                    <td>{{ $row->stokKeluar->sum('jumlah') }}</td>
                                                    <td>{{ $row->stok() }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer text-xs">
                                        <span><label>Stok (Barang Masuk)</label> : Total Pembelian Barang</span> |
                                        <span><label>Permintaan (Barang Masuk)</label> : Total Permintaan Unit Kerja</span> |
                                        <span><label>Sisa Stok</label> : Stok Awal - Permintaan Barang</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        var currentdate = new Date();
        var datetime = "Tanggal: " + currentdate.getDate() + "/" +
            (currentdate.getMonth() + 1) + "/" +
            currentdate.getFullYear() + " \n Pukul: " +
            currentdate.getHours() + ":" +
            currentdate.getMinutes() + ":" +
            currentdate.getSeconds()


        $("#table-data").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "info": true,
            "paging": true,
            "searching": true,
            buttons: [{
                extend: 'pdf',
                text: ' PDF',
                pageSize: 'A4',
                className: 'bg-danger btn-sm',
                title: 'show'
            }, {
                extend: 'excel',
                text: ' Excel',
                className: 'bg-success btn-sm',
                title: 'show'
            }],
            "bDestroy": true
        }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
    })
</script>
@endsection
@endsection