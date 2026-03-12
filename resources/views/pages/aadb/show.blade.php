@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 mt-3">
            <div class="col-sm-12">
                <h3 class="m-0 font-weight-bold text-dark">Daftar Kendaraan (AADB)</h3>
                <ol class="breadcrumb mt-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar AADB</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card-bbm shadow-sm">
                    <div class="card-header-bbm d-flex justify-content-between align-items-center p-4">
                        <div>
                            <h4 class="font-weight-bold mb-1">Data Inventaris Kendaraan</h4>
                            <p class="text-muted small mb-0">Kelola dan pantau seluruh aset kendaraan operasional</p>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm px-4 rounded-pill shadow-sm" data-toggle="modal" data-target="#modalFilter">
                            <i class="fas fa-filter mr-1"></i> Filter Data
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-data" class="table table-modern w-100">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>AKSI</th>
                                        <th class="text-left">UNIT KERJA</th>
                                        <th class="text-left">MERK/TIPE</th>
                                        <th>NO. POLISI</th>
                                        <th>ALOKASI</th>
                                        <th>REALISASI</th>
                                        <th>KONDISI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content custom-card-bbm">
            <div class="modal-header card-header-bbm">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-filter text-secondary mr-2"></i> Filter Data AADB
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="GET">
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold small text-uppercase text-muted">Unit Kerja</label>
                        <select name="filter_unit" class="form-control select2 shadow-sm">
                            <option value="">Semua Unit Kerja</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold small text-uppercase text-muted">Kategori Kendaraan</label>
                        <select name="filter_kategori" class="form-control select2 shadow-sm">
                            <option value="">Semua Kategori</option>
                            <option value="1">Kendaraan Jabatan</option>
                            <option value="2">Kendaraan Operasional</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="font-weight-bold small text-uppercase text-muted">Kondisi</label>
                        <div class="d-flex justify-content-between">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kondisi1" name="filter_kondisi" value="Baik" checked>
                                <label for="kondisi1" class="custom-control-label">Baik</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kondisi2" name="filter_kondisi" value="Rusak Ringan">
                                <label for="kondisi2" class="custom-control-label">Rusak Ringan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="kondisi3" name="filter_kondisi" value="Rusak Berat">
                                <label for="kondisi3" class="custom-control-label">Rusak Berat</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary px-4 shadow rounded-pill">
                        <i class="fas fa-search mr-2"></i> Tampilkan Hasil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Tambah</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="uker" class="col-form-label">Unit Kerja:</label>
                            <select name="uker" class="form-control" id="uker">
                                <option value="">-- Pilih Unit Kerja --</option>
                                @foreach($listUker as $row)
                                <option value="{{ $row->id_unit_kerja }}">
                                    {{ $row->unit_kerja }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="pegawai" class="col-form-label">*Nama Pegawai:</label>
                            <input type="text" class="form-control" id="pegawai" name="pegawai" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="nip" class="col-form-label">NIP:</label>
                            <input type="text" class="form-control number" id="nip" name="nip" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="kategori" class="col-form-label">Kategori:</label>
                            <select name="kategori" class="form-control" id="kategori">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($listKategori as $row)
                                <option value="{{ $row->id_kategori }}">{{ $row->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="timker" class="col-form-label">Tim Kerja:</label>
                            <input id="timker" type="text" class="form-control" name="timker">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="col-form-label">Status:</label> <br>
                            <div class="input-group">
                                <input type="radio" id="true" name="status" value="true">
                                <label for="true" class="my-auto ml-2 mr-5">Aktif</label>

                                <input type="radio" id="false" name="status" value="false">
                                <label for="false" class="my-auto ml-2">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        }, {
            text: ' Tambah',
            className: 'bg-primary',
            action: function(e, dt, button, config) {
                $('#createModal').modal('show');
            }
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>

<script>
    $(document).ready(function() {
        let uker = $('[name="uker"]').val();
        let kategori = $('[name="kategori"]').val();
        let status = $('[name="status"]').val();
        let kondisi = $('[name="kondisi"]').val();
        let userRole = '{{ Auth::user()->role_id }}';

        loadTable(uker, kategori, status, kondisi);

        function loadTable(uker, kategori, status, kondisi) {
            $.ajax({
                url: `{{ route('aadb.select') }}`,
                method: 'GET',
                data: {
                    uker: uker,
                    kategori: kategori,
                    status: status,
                    kondisi: kondisi
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('.table tbody');
                    tbody.empty();

                    if (response.message) {
                        tbody.append(`
                        <tr>
                            <td colspan="9">${response.message}</td>
                        </tr>
                    `);
                    } else {
                        // Jika ada data
                        $.each(response, function(index, item) {
                            let actionButton = '';
                            let deleteUrl = "{{ route('pegawai.delete', ':id') }}".replace(':id', item.id);
                            actionButton = `
                                <a href="#" class="btn btn-default btn-xs bg-danger rounded border-dark"
                                onclick="confirmRemove(event, '${deleteUrl}')">
                                    <i class="fas fa-trash-alt p-1" style="font-size: 12px;"></i>
                                </a>
                             `;
                            tbody.append(`
                                <tr>
                                    <td class="align-middle">${item.no} ${item.status}</td>
                                    <td class="align-middle">${item.aksi}</td>
                                    <td class="align-middle text-left">${item.uker}</td>
                                    <td class="align-middle">${item.merktipe}</td>
                                    <td class="align-middle">${item.nopolisi}</td>
                                    <td class="align-middle">${item.alokasi}</td>
                                    <td class="align-middle">${item.realisasi}</td>
                                    <td class="align-middle">${item.kondisi}</td>
                                </tr>
                            `);
                        });

                        $("#table-data").DataTable({
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
                                    title: 'aadb',
                                    exportOptions: {
                                        columns: [0, 2, 3, 4],
                                    },
                                }, {
                                    extend: 'excel',
                                    text: ' Excel',
                                    className: 'bg-success',
                                    title: 'aadb',
                                    exportOptions: {
                                        columns: [0, 2, 3, 4, 5, 6, 7, 8],
                                    },
                                },
                                userRole == 1 || userRole == 2 || userRole == 4 ? {
                                    text: ' Tambah',
                                    className: 'bg-primary',
                                    action: function(e, dt, button, config) {
                                        window.location.href = `{{ route('aadb.create') }}`;
                                    }
                                } : null
                            ],
                            "bDestroy": true
                        }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>
@endsection
@endsection