@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('usulan','aadb') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
                <h2 class="font-weight-bold text-dark">Peminjaman Kendaraan</h2>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid col-md-10">
        <div class="card custom-card-bbm shadow-sm">
            <form id="formPinjam" action="{{ route('usulan.store', 'pinjam') }}" method="POST">
                @csrf
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-md-6 border-right pr-md-5">
                            <h6 class="font-weight-bold text-primary mb-4 border-bottom pb-2">
                                <i class="fas fa-user-edit mr-2"></i>Data Peminjam
                            </h6>

                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-muted text-uppercase">Nama Pemakai / Unit Kerja</label>
                                <input type="text" name="peminjam" class="form-control shadow-sm" placeholder="Nama lengkap atau Unit Kerja" required>
                            </div>

                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-muted text-uppercase">Keperluan Penggunaan</label>
                                <textarea name="keperluan" class="form-control shadow-sm" rows="4" placeholder="Contoh: Menghadiri rapat koordinasi di..." required></textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label class="small font-weight-bold text-muted text-uppercase">Tujuan Perjalanan</label>
                                <input type="text" name="tujuan" class="form-control shadow-sm" placeholder="Kota atau Lokasi Spesifik" required>
                            </div>
                        </div>

                        <div class="col-md-6 pl-md-5 mt-4 mt-md-0">
                            <h6 class="font-weight-bold text-primary mb-4 border-bottom pb-2">
                                <i class="fas fa-calendar-check mr-2"></i>Waktu & Kendaraan
                            </h6>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-4">
                                        <label class="small font-weight-bold text-muted text-uppercase">Tanggal Mulai</label>
                                        <input type="date" name="tgl_mulai" class="form-control shadow-sm" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-4">
                                        <label class="small font-weight-bold text-muted text-uppercase">Jam Mulai</label>
                                        <input type="time" name="jam_mulai" class="form-control shadow-sm" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-4">
                                        <label class="small font-weight-bold text-muted text-uppercase">Tanggal Selesai</label>
                                        <input type="date" name="tgl_selesai" class="form-control shadow-sm" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-4">
                                        <label class="small font-weight-bold text-muted text-uppercase">Jam Selesai</label>
                                        <input type="time" name="jam_selesai" class="form-control shadow-sm" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-muted text-uppercase">Pilih Kendaraan (Tersedia)</label>
                                <select name="id_aadb" id="pilih-kendaraan" class="form-control select2 shadow-sm" required>
                                    <option value="">-- Pilih Kendaraan --</option>
                                    @foreach($aadb as $v)
                                    <option value="{{ $v->id_aadb }}" data-foto="{{ asset('dist/img/foto_aadb/'. $v->foto_barang) }}">
                                        {{ $v->no_polisi }} - {{ $v->merk_tipe }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="preview-container" class="mt-3 shadow-sm rounded border p-2 bg-white" style="display: none;">
                                <div class="text-center">
                                    <img id="vehicle-image" src="" class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                                    <div class="mt-2 py-1 bg-light">
                                        <small class="text-muted font-italic"><i class="fas fa-info-circle"></i> Tampilan visual unit yang dipilih</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-4 border-top d-flex justify-content-between">
                    <button type="button" class="btn btn-link text-muted" onclick="window.history.back()">Kembali ke Pilihan Layanan</button>
                    <button type="submit" class="btn btn-primary px-5 shadow rounded-pill" onclick="confirmSubmit(event, 'formPinjam')">
                        <i class="fas fa-check-circle mr-2"></i> <b>Kirim Pengajuan</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@section('js')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            dropdownAutoWidth: true, // Membuat dropdown melebar mengikuti teks
            placeholder: "Cari nomor polisi atau tipe kendaraan...",
            templateResult: formatState // Menampilkan informasi lebih detail saat dipilih
        });
    });

    // Opsional: Fungsi untuk mempercantik tampilan opsi kendaraan di dropdown
    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $(
            '<span><i class="fas fa-car mr-2 text-primary"></i>' + state.text + '</span>'
        );
        return $state;
    };

    $('#pilih-kendaraan').on('change', function() {
        const selected = $(this).find('option:selected');
        const fotoUrl = selected.data('foto');
        const defaultFoto = "https://cdn-icons-png.flaticon.com/128/7571/7571054.png";

        if ($(this).val()) {
            $('#preview-container').fadeIn();
            // Cek jika fotoUrl ada, jika tidak pakai default
            $('#vehicle-image').attr('src', fotoUrl ? fotoUrl : defaultFoto);
        } else {
            $('#preview-container').fadeOut();
        }
    });
</script>
@endsection
@endsection