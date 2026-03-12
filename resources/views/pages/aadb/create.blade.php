@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid col-md-10">
        <div class="row mb-3 mt-3">
            <div class="col-sm-12">
                <h3 class="m-0 font-weight-bold text-dark">Tambah Kendaraan</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('aadb') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title font-weight-bold text-primary">
                    <i class="fas fa-car-side mr-2"></i>Tambah Data Kendaraan (AADB)
                </h5>
            </div>

            <form id="form" action="{{ route('aadb.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 border-right">
                            <label class="small font-weight-bold text-muted text-uppercase d-block text-center mb-3">Foto Kendaraan</label>
                            <div class="text-center">
                                <div class="mb-3">
                                    <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/128/7571/7571054.png"
                                        alt="Foto Barang" class="img-fluid rounded shadow-sm border" style="max-height: 250px; width: 100%; object-fit: cover;">
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="foto" class="custom-file-input previewImg" id="uploadFoto" data-preview="modal-foto" accept="image/*">
                                    <label class="custom-file-label text-left" for="uploadFoto">Pilih file...</label>
                                </div>
                                <small class="text-muted d-block mt-2 font-italic py-2 bg-light rounded">
                                    <i class="fas fa-info-circle mr-1"></i> Format: JPG, PNG (Max 2MB)
                                </small>
                            </div>
                        </div>

                        <div class="col-md-9 pl-md-4">
                            <h6 class="font-weight-bold text-secondary mb-4 border-bottom pb-2 text-uppercase small">Informasi Identitas</h6>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold text-muted">UNIT KERJA</label>
                                    <select name="uker" class="form-control select2" required>
                                        @if (Auth::user()->role_id != 4)
                                        <option value="">-- Pilih Unit Kerja --</option>
                                        @foreach ($uker as $row)
                                        <option value="{{ $row->id_unit_kerja }}">{{ $row->unit_kerja }}</option>
                                        @endforeach
                                        @else
                                        <option value="{{ Auth::user()->pegawai->uker_id }}">{{ Auth::user()->pegawai->uker->unit_kerja }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold text-muted">KATEGORI</label>
                                    <select name="kategori" class="form-control select2" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $row)
                                        <option value="{{ $row->id_kategori }}">{{ $row->kode }} - {{ $row->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="small font-weight-bold text-muted">JENIS AADB</label>
                                    <select name="jenis" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="bmn">BMN</option>
                                        <option value="sewa">Sewa</option>
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="small font-weight-bold text-muted">NO. POLISI</label>
                                    <input type="text" class="form-control" name="nopolisi" placeholder="B 1234 XXX" required>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="small font-weight-bold text-muted">NUP</label>
                                    <input type="text" class="form-control" name="nup" placeholder="Nomor Urut Pendaftaran">
                                </div>

                                <div class="col-md-12 form-group">
                                    <label class="small font-weight-bold text-muted">MERK / TIPE</label>
                                    <input type="text" class="form-control" name="merktipe" placeholder="Contoh: Mitsubishi Xpander" required>
                                </div>
                            </div>

                            <h6 class="font-weight-bold text-secondary mt-3 mb-4 border-bottom pb-2 text-uppercase small">Detail Administrasi</h6>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold text-muted">STATUS PENGGUNAAN</label>
                                    <select name="kualifikasi" class="form-control" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="fungsional">Fungsional</option>
                                        <option value="jabatan">Jabatan</option>
                                        <option value="operasional">Operasional</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold text-muted">KONDISI</label>
                                    <select name="kondisi" class="form-control" required>
                                        <option value="">-- Pilih Kondisi --</option>
                                        @foreach ($kondisi as $row)
                                        <option value="{{ $row->id_kondisi }}">{{ $row->nama_kondisi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold text-muted">TANGGAL PEROLEHAN</label>
                                    <input type="date" class="form-control" name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold text-muted">NILAI PEROLEHAN (RP)</label>
                                    <input type="text" class="form-control number" name="nilai" placeholder="0" required>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold text-muted">STATUS KETERSEDIAAN</label>
                                    <select name="status" class="form-control bg-light font-weight-bold">
                                        <option value="true" class="text-success">Tersedia</option>
                                        <option value="false" class="text-danger">Tidak Tersedia</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold text-muted">KETERANGAN</label>
                                    <input type="text" class="form-control" name="keterangan" placeholder="...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-4 text-right">
                    <button type="button" class="btn btn-default px-4 mr-2" onclick="window.history.back()">Batal</button>
                    <button type="button" class="btn btn-primary px-5 shadow-sm rounded-pill" onclick="confirmSubmit(event, 'form')">
                        <i class="fas fa-save mr-2"></i> <b>Simpan Data AADB</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection