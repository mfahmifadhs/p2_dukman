@extends('layouts.app')

@section('content')


<div class="content-header">
    <div class="container col-sm-9">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="m-0">Usulan</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan', $form) }}">Daftar</a></li>
                    <li class="breadcrumb-item active">Verifikasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container col-md-9">
        <div class="card border border-dark">
            <div class="card-header">
                <label class="mt-2">
                    Verifikasi Usulan
                </label>
                <div class="card-tools">
                    <div class="input-group">
                        <div class="form-group mr-2 mt-2">
                            <a href="{{ route('usulan.edit', $data->id_usulan) }}" class="btn btn-warning border-dark btn-xs mt-0 p-1">
                                <i class="fas fa-edit"></i> <span style="font-size: 14px;">Edit</span>
                            </a>
                        </div>
                        <div class="form-group mr-1">
                            <form id="form-true" action="{{ route('usulan.verif', $id) }}" method="GET">
                                @csrf
                                <input type="hidden" name="usulan" value="{{ $id }}">
                                <input type="hidden" name="persetujuan" value="true">
                                <input type="hidden" name="tanggal_selesai" value="true">
                                <button type="submit" class="btn btn-success border-dark btn-sm mt-2" onclick="confirmTrue(event)">
                                    <i class="fas fa-check-circle"></i> Setuju
                                </button>
                            </form>
                        </div>

                        <div class="form-group ml-1">
                            <form id="form-false" action="{{ route('usulan.verif', $id) }}" method="GET">
                                @csrf
                                <input type="hidden" name="persetujuan" value="false">
                                <input type="hidden" name="alasan_penolakan" id="alasan_penolakan">

                                <button type="submit" class="btn btn-danger border-dark btn-sm mt-2" onclick="confirmFalse(event)">
                                    <i class="fas fa-times-circle"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header d-flex text-center flex-wrap justify-content-center">
                @php
                if (!$data->status_proses) {
                $verifikasi = 'bg-warning';
                } else if ($data->status_persetujuan == 'false') {
                $verifikasi = 'bg-danger';
                } else if ($data->status_persetujuan == 'true') {
                $verifikasi = 'bg-success';
                } else {
                $verifikasi = '';
                }
                @endphp
                <span class="w-25 w-md-25 border border-dark {{ $verifikasi }} p-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-1 fa-3x"></i>
                    <b class="ms-3 ml-2">Verifikasi</b>
                </span>
                @php
                if ($data->status_proses == 'selesai') {
                $proses = 'bg-success';
                } else if ($data->status_persetujuan == 'true' && $data->status_proses == 'proses') {
                $proses = 'bg-warning';
                } else {
                $proses = '';
                }
                @endphp
                <span class="w-50 w-md-50 border border-dark {{ $proses }} p-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-2 fa-3x"></i>
                    <b class="ms-3 ml-2">Proses</b>
                </span>
                @php
                if ($data->status_proses == 'selesai') {
                $selesai = 'bg-success';
                } else {
                $selesai = '';
                }
                @endphp
                <span class="w-25 w-md-25 border border-dark {{ $selesai }} p-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-3 fa-3x"></i>
                    <b class="ms-3 ml-2">Selesai</b>
                </span>
                <!-- <span class="w-25 border border-secondary p-2">
                        <i class="fas fa-clock fa-3x {{ $data->status_persetujuan == 'true' ? 'text-warning' : 'text-dark' }}"></i>
                        <h6 class="text-xs text-uppercase mt-2 {{ $data->status_persetujuan == 'true' ? 'text-warning' : 'text-secondary' }}">
                            Proses {{ $data->kategori }}
                        </h6>
                    </span> -->
            </div>
            <div class="card-body small">
                <div class="d-flex">
                    <div class="w-50 text-left">
                        <label>Detail Naskah</label>
                    </div>
                    <div class="w-50 text-right text-secondary">
                        #{{ Carbon\Carbon::parse($data->created_at)->format('dmyHis').$data->id_pengajuan }}-{{ $data->id_usulan }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <label class="w-25">Tanggal {{ $data->kategori }}</label>
                            <span class="w-75">: {{ Carbon\Carbon::parse($data->tanggal_usulan)->isoFormat('DD MMMM Y') }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-25">Nomor Naskah</label>
                            <span class="w-70 text-uppercase">: {{ $data->nomor_usulan }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-25">Hal</label>
                            <span class="w-75">: {{ $data->form->nama_form }}</span>
                        </div>
                        @if ($data->form_id == 5)
                        <div class="input-group">
                            <label class="w-25">Bulan Permintaan</label>
                            <span class="w-75">: {{ Carbon\Carbon::parse($data->tanggal_selesai)->isoFormat('MMMM Y') }}</span>
                        </div>
                        @endif
                        @if ($data->status_persetujuan == 'true')
                        <div class="input-group">
                            <label class="w-25">Surat Usulan</label>
                            <span class="w-75">:
                                <a href="{{ route('usulan.surat', $data->id_usulan) }}" target="_blank">
                                    <u><i class="fas fa-file-alt"></i> Lihat Surat</u>
                                </a>
                            </span>
                        </div>
                        @endif
                        <div class="input-group">
                            <label class="w-25">Nama</label>
                            <span class="w-75">: {{ $data->user->pegawai->nama_pegawai }}</span>
                        </div>

                        <div class="input-group">
                            <label class="w-25">Jabatan</label>
                            <span class="w-75">:
                                {{ ucwords(strtolower($data->user->pegawai->jabatan->jabatan)) }}
                                {{ ucwords(strtolower($data->user->pegawai->tim_kerja)) }}
                            </span>
                        </div>

                        <div class="input-group">
                            <label class="w-25">Unit Kerja</label>
                            <span class="w-75">:
                                {{ ucwords(strtolower($data->user->pegawai->uker->unit_kerja)) }} |
                                {{ ucwords(strtolower($data->user->pegawai->uker->utama->unit_utama)) }}
                            </span>
                        </div>
                        @if ($data->keterangan)
                        <div class="input-group">
                            <label class="w-25">Keterangan</label>
                            <span class="w-75">: {{ $data->keterangan }}</span>
                        </div>
                        @endif

                        @if ($data->file_pendukung)
                        <div class="input-group">
                            <label class="w-25">Data Pendukung</label>
                            <span class="w-75">:
                                <a href="{{ route('usulan.viewPdf', $data->id_usulan) }}" class="btn btn-danger btn-xs" target="_blank">
                                    <i class="fas fa-file-pdf"></i> <small>{{ $data->file_pendukung }}</small>
                                </a>
                            </span>
                        </div>
                        @endif

                        @if ($data->status_persetujuan == 'false')
                        <div class="input-group">
                            <label class="w-25">Alasan Ditolak</label>
                            <span class="w-75 text-danger">: {{ $data->keterangan_tolak }}</span>
                        </div>
                        @endif
                    </div>
                    @if ($data->form_id == 3 && $data->status_proses == 'selesai')
                    <div class="col-md-4">
                        @if (!$data->tanggal_ambil)
                        <div class="input-group">
                            <label class="w-50">Tanggal Terima</label>
                            <span class="w-50">: {{ Carbon\Carbon::parse($data->tanggal_selesai)->isoFormat('DD MMMM Y') }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-50">Nama Penerima</label>
                            <span class="w-50">: {{ $data->nama_penerima }}</span>
                        </div>
                        <div class="input-group">
                            <label class="w-50">Jabatan</label>
                            <span class="w-50">: Staf</span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <!-- ========================= UKT & GDN ============================ -->
            @if (in_array($data->form_id, [1,2]))
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Daftar Barang</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Uraian</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach ($data->detail as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->gdn ? $row->gdn->nama_perbaikan .',' : '' }} {!! nl2br($row->judul) !!}</td>
                                <td>{!! nl2br($row->uraian) !!}</td>
                                <td>{!! nl2br($row->keterangan) !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- ========================== ATK ================================= -->
            @if ($data->form_id == 3)
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Permintaan</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Deskripsi</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Stok Uker</th>
                                <th>Stok Gudang</th>
                                <th>Tanggal Permintaan Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->detailAtk as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->atk->nama_barang }}</td>
                                <td>{{ $row->atk->deskripsi }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td class="text-center">{{ $row->jumlah.' '.$row->satuan->nama_satuan }} </td>
                                <td class="text-center">{{ $row->atk->stokUker($row->usulan->pegawai->uker_id).' '.$row->atk->satuan->nama_satuan }}</td>
                                <td class="text-center">{{ $row->atk->stok().' '.$row->atk->satuan->nama_satuan }}</td>
                                <td class="text-center">{{ $row->atk->permintaanAkhir($row->id_detail) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- ========================== BMHP ================================= -->
            @if ($data->form_id == 6)
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Permintaan</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Deskripsi</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Stok</th>
                            </tr>
                        </thead>

                        <tbody class="text-xs">
                            @foreach ($data->detailBmhp as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->bmhp->nama_barang }}</td>
                                <td>{{ $row->bmhp->deskripsi }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td class="text-center">{{ $row->jumlah.' '.$row->satuan->nama_satuan }} </td>
                                <td class="text-center">{{ $row->bmhp->stok().' '.$row->bmhp->satuan->nama_satuan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- ========================== AADB SERVIS ================================= -->
            @if ($data->form_id == 4)
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Pemeliharaan</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>No. Polisi</th>
                                <th>Kendaraan</th>
                                <th>Uraian</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach ($data->detailServis as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->aadb->no_polisi }}</td>
                                <td>{{ $row->aadb->kategori->nama_kategori.' '.$row->aadb->merk_tipe }}</td>
                                <td>{{ $row->uraian }}</td>
                                <td>{{ $row->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- ========================== AADB BBM ================================= -->
            @if ($data->form_id == 5)
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Pemeliharaan</label>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered border border-dark">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>No. Polisi</th>
                                <th>Kendaraan</th>
                                <th>Merk/Tipe</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach ($data->detailBbm as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->aadb->no_polisi }}</td>
                                <td>{{ $row->aadb->kategori->nama_kategori }}</td>
                                <td>{{ $row->aadb->merk_tipe }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@section('js')

<script>
    function confirmTrue(event) {
        event.preventDefault();

        const form = document.getElementById('form-true');

        Swal.fire({
            title: 'Setuju',
            text: 'Pilih tanggal pengambilan',
            icon: 'question',
            html: `
                <h6></h6>
                <input type="date" id="tanggal" class="swal2-input ml-0 mt-0 w-100 border border-dark text-center" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="Tanggal Ambil">
            `,
            preConfirm: () => {
                const tanggal = document.getElementById('tanggal').value;

                // Jika belum ada tanggal yang dipilih, set default text
                if (!tanggal) {
                    document.getElementById('tanggal').setAttribute('placeholder', 'Tanggal belum dipilih');
                }

                if (!tanggal) {
                    Swal.showValidationMessage('Harap isi semua input!');
                    return false;
                }

                return {
                    tanggal: tanggal
                };
            },
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            const selectedDate = result.value.tanggal;
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Proses...',
                    text: 'Mohon menunggu.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                document.querySelector('[name="tanggal_selesai"]').value = selectedDate;
                form.submit();
            }
        });
    }

    function confirmFalse(event) {
        event.preventDefault();

        const form = document.getElementById('form-false');

        Swal.fire({
            title: 'Konfirmasi Penolakan',
            text: 'Apakah Anda yakin ingin menolak usulan ini?',
            icon: 'warning',
            input: 'textarea',
            inputPlaceholder: 'Berikan alasan penolakan di sini...',
            inputAttributes: {
                'aria-label': 'Tulis alasan penolakan di sini'
            },
            showCancelButton: true,
            confirmButtonText: 'Tolak',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan penolakan harus diisi!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const alasanPenolakan = result.value;

                Swal.fire({
                    title: 'Ditolak!',
                    text: 'Usulan telah ditolak dengan alasan: ' + alasanPenolakan,
                    icon: 'success'
                });

                document.getElementById('alasan_penolakan').value = alasanPenolakan;
                form.submit();
            }
        });
    }
</script>
@endsection

@endsection
