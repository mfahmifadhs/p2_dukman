@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-9">
        <div class="row mb-3 mt-3">
            <div class="col-sm-12">
                <h3 class="m-0 font-weight-bold text-dark">Edit Data Kendaraan</h3>
                <ol class="breadcrumb mt-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('aadb') }}">Daftar AADB</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid col-md-9">
        <div class="card custom-card-bbm shadow-sm">
            <div class="card-header-bbm p-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-edit fa-lg text-primary mr-3"></i>
                    <div>
                        <h5 class="font-weight-bold mb-0">Form Pembaruan Data</h5>
                        <small class="text-muted">Pastikan data kendaraan sesuai dengan dokumen fisik terkini</small>
                    </div>
                </div>
            </div>

            <form id="form" action="{{ route('aadb.update', $id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center border-right">
                            <label class="font-weight-bold d-block mb-3 text-secondary text-uppercase small">Foto Kendaraan</label>
                            <div class="image-upload-wrapper mb-3">
                                @if ($data->foto_barang)
                                    <img id="modal-foto" src="{{ asset('dist/img/foto_aadb/'. $data->foto_barang) }}" class="img-fluid rounded shadow-sm border" style="max-height: 250px; width: 100%; object-fit: cover;">
                                @else
                                    <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/128/7571/7571054.png" class="img-fluid opacity-50 p-4" style="max-height: 200px;">
                                @endif
                            </div>
                            
                            <div class="btn-group w-100">
                                <label class="btn btn-outline-primary btn-sm btn-block shadow-sm">
                                    <i class="fas fa-camera mr-1"></i> Ganti Foto
                                    <input type="file" name="foto" class="previewImg d-none" data-preview="modal-foto" accept="image/*">
                                </label>
                            </div>
                            <p class="text-muted small mt-2 italic">Klik tombol di atas untuk mengganti gambar</p>
                        </div>

                        <div class="col-md-8 pl-md-4 mt-4 mt-md-0">
                            <h6 class="font-weight-bold text-primary mb-4 border-bottom pb-2">Identitas & Spesifikasi</h6>
                            
                            <div class="row form-group align-items-center mb-3">
                                <label class="col-sm-4 font-weight-normal mb-0">Unit Kerja</label>
                                <div class="col-sm-8">
                                    <select name="uker" class="form-control select2 shadow-sm" required>
                                        <option value="">-- Pilih Unit Kerja --</option>
                                        @foreach ($uker as $row)
                                            <option value="{{ $row->id_unit_kerja }}" {{ $row->id_unit_kerja == $data->uker_id ? 'selected' : '' }}>
                                                {{ $row->unit_kerja }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group align-items-center mb-3">
                                <label class="col-sm-4 font-weight-normal mb-0">Kategori</label>
                                <div class="col-sm-8">
                                    <select name="kategori" class="form-control select2 shadow-sm" required>
                                        @foreach ($kategori as $row)
                                            <option value="{{ $row->id_kategori }}" {{ $row->id_kategori == $data->kategori_id ? 'selected' : '' }}>
                                                {{ $row->kode }} - {{ $row->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group align-items-center mb-3">
                                <label class="col-sm-4 font-weight-normal mb-0">Merk / Tipe</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control shadow-sm" name="merktipe" value="{{ $data->merk_tipe }}" required>
                                </div>
                            </div>

                            <div class="row form-group align-items-center mb-3">
                                <label class="col-sm-4 font-weight-normal mb-0">No. Polisi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control font-weight-bold shadow-sm" name="nopolisi" value="{{ $data->no_polisi }}" required style="letter-spacing: 1px;">
                                </div>
                            </div>

                            <h6 class="font-weight-bold text-primary mb-4 border-bottom pb-2 mt-4">Administrasi & Anggaran</h6>

                            <div class="row form-group align-items-center mb-3">
                                <label class="col-sm-4 font-weight-normal mb-0">Status Penggunaan</label>
                                <div class="col-sm-8">
                                    <select name="kualifikasi" class="form-control shadow-sm" required>
                                        <option value="fungsional" {{ $data->kualifikasi == 'fungsional' ? 'selected' : '' }}>Fungsional</option>
                                        <option value="jabatan" {{ $data->kualifikasi == 'jabatan' ? 'selected' : '' }}>Jabatan</option>
                                        <option value="operasional" {{ $data->kualifikasi == 'operasional' ? 'selected' : '' }}>Operasional</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group align-items-center mb-3">
                                <label class="col-sm-4 font-weight-normal mb-0">Nilai Alokasi (Rp)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control number font-weight-bold text-success shadow-sm" name="alokasi" value="{{ number_format($data->nilai_alokasi, 0, ',', '.') }}" required>
                                </div>
                            </div>

                            <div class="row form-group align-items-center mb-3">
                                <label class="col-sm-4 font-weight-normal mb-0">Status Ketersediaan</label>
                                <div class="col-sm-8">
                                    <select name="status" class="form-control shadow-sm">
                                        <option value="true" {{ $data->status == 'true' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="false" {{ $data->status == 'false' ? 'selected' : '' }}>Tidak Tersedia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white p-4 border-top d-flex justify-content-between">
                    <button type="button" class="btn btn-link text-muted" onclick="window.history.back()">Batal</button>
                    <button type="submit" class="btn btn-primary px-5 shadow rounded-pill" onclick="confirmSubmit(event, 'form')">
                        <i class="fas fa-save mr-2"></i> <b>Simpan Perubahan</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
