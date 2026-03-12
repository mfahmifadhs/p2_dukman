@extends('layouts.app')

@section('content')


<div class="content-header">
    <div class="container col-md-9">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Usulan</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan', $data->form->kode_form) }}">Daftar</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container col-md-9">
        <div class="card border border-dark">
            <div class="card-header">
                <label class="mt-2">
                    Detail Usulan
                </label>
                <div class="card-tools">
                    @if ($data->form_id == 3 && $data->status_persetujuan != 'false')
                    <a href="#" onclick="confirmReusul(event, `{{ route('atk-bucket.reusul', $data->id_usulan) }}`)">
                        <span class="btn btn-default badge mt-2 p-2 border border-dark">
                            <i class="fas fa-basket-shopping"></i> Usulkan Kembali
                        </span>
                    </a>
                    @endif
                    @if ((!$data->status_persetujuan && Auth::user()->role_id == 4) || in_array(Auth::user()->role_id, [1, 2]))
                    <a href="{{ route('usulan.edit', $data->id_usulan) }}" class="btn btn-warning border-dark btn-xs mt-0 p-1">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <a href="#" class="btn btn-danger border-dark btn-xs mt-0 p-1" onclick="confirmLink(event, `{{ route('usulan.delete', $data->id_usulan) }}`)">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
                    @endif

                    @if ($data->status_persetujuan == 'true')
                    <span class="badge badge-success mt-2 p-2 border border-dark">
                        <i class="fas fa-check-circle"></i> Permintaan Diterima
                    </span>
                    @endif

                    @if ($data->status_persetujuan == 'false')
                    <span class="badge badge-danger mt-2 p-2 border border-dark">
                        <i class="fas fa-times-circle"></i> Permintaan Ditolak
                    </span>
                    @if ($data->form_id == 3 && Auth::user()->role_id == 4)
                    <a href="#" onclick="confirmReusul(event, `{{ route('atk-bucket.reusul', $data->id_usulan) }}`)">
                        <span class="btn btn-primary badge mt-2 p-2 border border-dark">
                            <i class="fas fa-file-circle-plus"></i> Usulkan Kembali
                        </span>
                    </a>
                    @elseif (Auth::user()->role_id == 4)
                    <a href="#" onclick="confirmReusul(event, `{{ route('usulan.edit', $data->id_usulan) }}`)">
                        <span class="btn btn-primary badge mt-2 p-2 border border-dark">
                            <i class="fas fa-file-circle-plus"></i> Usulkan Kembali
                        </span>
                    </a>
                    @endif
                    @endif
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
                        @if ($data->keterangan)
                        <div class="input-group">
                            <label class="w-25">Keterangan</label>
                            <span class="w-75">: {{ $data->keterangan }}</span>
                        </div>
                        @endif

                        @if ($data->status_persetujuan == 'false')
                        <div class="input-group">
                            <label class="w-25">Alasan Ditolak</label>
                            <span class="w-75 text-danger">: {{ $data->keterangan_tolak }}</span>
                        </div>
                        @endif
                    </div>
                    @if (($data->form_id == 3 || $data->form_id == 6) && $data->status_proses == 'selesai')
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
                        <div class="input-group">
                            <label class="w-50">SBBK</label>
                            <span class="w-50">: 
                                <a href="{{ route('usulan.surat', $data->id_usulan) }}" target="_blank">
                                    <u><i class="fas fa-file-alt"></i> Lihat Surat</u>
                                </a>
                            </span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <!-- ========================= UKT & GDN ============================ -->
            @if (in_array($data->form_id, [1,2]))
            <div class="card-body small" style="overflow-y: auto; max-height: 50vh;">
                <label>Uraian Pekerjaan</label>
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
            @if (in_array($data->form_id, [3,6]))
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
                            </tr>
                        </thead>
                        @if ($data->form_id == 3)
                        <tbody class="text-xs">
                            @foreach ($data->detailAtk as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->atk->nama_barang }}</td>
                                <td>{{ $row->atk->deskripsi }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td class="text-center">{{ $row->jumlah.' '.$row->satuan->nama_satuan }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif

                        @if ($data->form_id == 6)
                        <tbody class="text-xs">
                            @foreach ($data->detailBmhp as $row)
                            <tr class="bg-white">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $row->bmhp->nama_barang }}</td>
                                <td>{{ $row->bmhp->deskripsi }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td class="text-center">{{ $row->jumlah.' '.$row->satuan->nama_satuan }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
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
</div>
@endsection
