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
                <h2 class="font-weight-bold text-dark">Buat Usulan Servis</h2>
            </div>
        </div>
    </div>
</div>

<section class="content py-4">
    <div class="container-fluid col-md-8">
        <div class="card custom-card">
            <form id="form" action="{{ route('usulan.store', 'servis') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <h4 class="font-weight-bold mb-1">Tambah Usulan Pemeliharaan AADB</h4>
                    <p class="text-muted small mb-0">Input detail pekerjaan yang berkaitan dengan pemeliharaan kendaraan operasional.</p>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12 form-group mb-4">
                            <label><i class="fas fa-car mr-2"></i> Kendaraan</label>
                            <select name="aadb[]" class="form-control select2 aadb" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach($aadb as $row)
                                <option value="{{ $row->id_aadb }}">
                                    {{ $row->no_polisi && $row->no_polisi != '-' ? $row->no_polisi.' - '.$row->merk_tipe : $row->merk_tipe }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 form-group mb-4">
                            <label><i class="fas fa-align-left mr-2"></i> Uraian Perbaikan</label>
                            <textarea name="uraian[]" class="form-control" rows="5" placeholder="Jelaskan secara detail bagian yang rusak atau perlu diservis..." required></textarea>
                        </div>

                        <div class="col-md-12 form-group mb-4">
                            <label><i class="fas fa-info-circle mr-2"></i> Keterangan Tambahan (Opsional)</label>
                            <textarea class="form-control" name="keterangan[]" rows="2" placeholder="Catatan tambahan jika ada..."></textarea>
                        </div>

                        <div class="col-md-12 form-group mb-2">
                            <label class="small font-weight-bold text-muted text-uppercase">
                                <i class="fas fa-paperclip mr-2"></i> Data Pendukung (PDF)
                            </label>

                            <div class="upload-area p-4 border rounded text-center bg-light"
                                onclick="document.getElementById('file-input').click();"
                                style="border: 2px dashed #ccc; cursor: pointer;">

                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>

                                <p class="text-instruction mb-1 font-weight-bold text-dark">
                                    Klik untuk Upload Foto Kerusakan
                                </p>

                                <p id="text-sub" class="text-muted small">
                                    Gabungkan semua foto dalam 1 file PDF (Maks. 2MB)
                                </p>

                                <input type="file" id="file-input" name="file" class="d-none"
                                    onchange="displaySelectedFile(this)" accept=".pdf" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white p-4 text-right">
                    <a href="{{ route('usulan.create', 'pilihan') }}" class="btn btn-link text-muted mr-3">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 shadow" onclick="confirmSubmit(event, 'form')">
                        <i class="fas fa-paper-plane mr-2"></i> <b>Kirim Usulan</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@section('js')

<script>
    function displaySelectedFile(input) {
        // Mencari elemen relatif terhadap input yang sedang diubah
        const wrapper = input.closest('.upload-wrapper');
        const textInstruction = wrapper.querySelector('.text-instruction');
        const textSub = wrapper.querySelector('.text-sub');

        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;

            // Ubah teks instruksi menjadi nama file
            textInstruction.innerHTML = `<i class="fas fa-file-pdf text-danger mr-2"></i> ${fileName}`;

            // Ubah teks sub menjadi status sukses
            textSub.innerHTML = `<span class="text-success font-weight-bold"><i class="fas fa-check"></i> File terpilih</span>`;

            // Beri tanda visual pada kotak
            wrapper.style.borderColor = "#28a745";
            wrapper.style.background = "#f4faf6";
        } else {
            // Kembalikan ke tampilan awal jika batal
            textInstruction.textContent = "Klik untuk Upload Foto Kerusakan";
            textSub.textContent = "Gabungkan semua foto dalam 1 file PDF (Maks. 2MB)";
            wrapper.style.borderColor = "#ccc";
            wrapper.style.background = "#f8f9fa";
        }
    }
</script>

<script>
    $(".aadb").select2()
    $(function() {
        $("#table-show").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')

        $('.input-format').on('input', function() {
            // Menghapus karakter selain angka (termasuk tanda titik koma sebelumnya)
            var value = $(this).val().replace(/[^0-9]/g, '');

            // Format dengan menambahkan titik koma setiap tiga digit
            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Memasukkan nilai yang sudah diformat kembali ke input
            $(this).val(formattedValue);
        });
    })

    $(document).on('click', '.btn-tambah-baris', function(e) {
        e.preventDefault();
        var container = $('.section-item');
        var templateRow = $('.section-item').first().clone();
        templateRow.find(':input').val('');
        templateRow.find('.jumlah').val('1');
        templateRow.find('.title').text('Kendaraan ' + (container.length + 1));
        $('.section-item:last').after(templateRow);
        toggleHapusBarisButton();

        templateRow.find('.input-format').on('input', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');
            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $(this).val(formattedValue);
        });
    });

    $(document).on('click', '.btn-hapus-baris', function(e) {
        e.preventDefault();
        var container = $('.section-item');
        if (container.length > 1) {
            $(this).closest('.form-group').prev('.section-item').remove();
            toggleHapusBarisButton();
        } else {
            alert('Minimal harus ada satu baris.');
        }
    });

    $('.btn-hapus-baris').toggle($('.section-item').length > 1);

    function toggleHapusBarisButton() {
        var container = $('.section-item');
        var btnHapusBaris = $('.btn-hapus-baris');
        btnHapusBaris.toggle(container.length > 1);
    }
</script>
@endsection


@endsection