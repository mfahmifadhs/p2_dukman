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
                <h2 class="font-weight-bold text-dark">Buat Usulan BBM</h2>
            </div>
        </div>
    </div>
</div>

<section class="content py-4">
    <div class="container-fluid col-md-10">
        <div class="card custom-card-bbm">
            <div class="card-header-bbm">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="font-weight-bold mb-0">
                            <i class="fas fa-gas-pump mr-2"></i>Usulan Permintaan BBM
                        </h4>
                    </div>
                    <div class="col-sm-6 text-sm-right mt-2 mt-sm-0">
                        <span class="badge badge-success px-3 py-2">Periode Rutin</span>
                    </div>
                </div>
            </div>

            <form id="form" action="{{ route('usulan.store', 'bbm') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group mb-4 p-3 bg-light rounded shadow-sm border-left border-success" style="border-left-width: 5px !important;">
                        <label class="font-weight-bold text-dark"><i class="far fa-calendar-alt mr-2"></i>Bulan Permintaan</label>
                        <div class="col-md-4 px-0">
                            <input type="month" class="form-control form-control-lg border-success" name="bulan_permintaan" 
                                   value="{{ \Carbon\Carbon::now()->format('Y-m') }}" required>
                        </div>
                        <small class="text-muted mt-2 d-block">* Usulan diajukan untuk kebutuhan bahan bakar di bulan berikutnya.</small>
                    </div>

                    <div class="d-flex justify-content-between align-items-end mb-2 px-1">
                        <label class="font-weight-bold text-dark mb-0">Daftar AADB (Kendaraan Dinas)</label>
                        <span class="small text-muted">Total: {{ count($aadb) }} Kendaraan</span>
                    </div>

                    <div class="table-scroll">
                        <table class="table table-modern m-0">
                            <thead class="text-center sticky-top">
                                <tr>
                                    <th class="py-3">No</th>
                                    <th class="py-3">No. Polisi</th>
                                    <th class="py-3 text-left">Kategori</th>
                                    <th class="py-3 text-left">Merk/Tipe</th>
                                    <th class="py-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="selectAll">
                                            <label class="custom-control-label" for="selectAll">Pilih</label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach ($aadb as $row)
                                <tr>
                                    <td class="text-center align-middle text-muted">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle font-weight-bold">{{ $row->no_polisi }}</td>
                                    <td class="align-middle text-uppercase">{{ $row->kategori->nama_kategori }}</td>
                                    <td class="align-middle text-uppercase">{{ $row->merk_tipe }}</td>
                                    <td class="text-center align-middle">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="id_aadb[]" class="custom-control-input confirm-check" 
                                                   id="check-{{ $row->id_aadb }}" value="{{ $row->id_aadb }}">
                                            <label class="custom-control-label" for="check-{{ $row->id_aadb }}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white p-4 text-right">
                    <a href="{{ route('usulan.create', 'aadb') }}" class="btn btn-link text-muted mr-3">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 shadow" onclick="confirmSubmit(event, 'form')">
                        <i class="fas fa-paper-plane mr-2"></i> <b>Kirim Usulan</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Script Select All yang lebih Smooth
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.confirm-check');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            // Trigger perubahan visual jika diperlukan
            if(this.checked) {
                checkbox.closest('tr').classList.add('bg-light');
            } else {
                checkbox.closest('tr').classList.remove('bg-light');
            }
        });
    });

    // Highlight row saat checkbox diklik individu
    document.querySelectorAll('.confirm-check').forEach(check => {
        check.addEventListener('change', function() {
            if(this.checked) {
                this.closest('tr').classList.add('bg-light');
            } else {
                this.closest('tr').classList.remove('bg-light');
            }
        });
    });
</script>
@section('js')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectAllCheckbox = document.getElementById("selectAll");
        let checkboxes = document.querySelectorAll(".confirm-check");
        let hiddenContainer = document.getElementById("hidden-container");

        // Select All Checkbox
        selectAllCheckbox.addEventListener("change", function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
                toggleHiddenInput(checkbox);
            });
        });

        // Event Listener untuk Checkbox Individu
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                toggleHiddenInput(checkbox);
            });
        });

        // Fungsi Menambah/Menghapus Input Hidden
        function toggleHiddenInput(checkbox) {
            let aadbId = checkbox.getAttribute("data-id");
            let existingInput = document.getElementById("hidden-aadb-" + aadbId);

            if (checkbox.checked) {
                if (!existingInput) {
                    let hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = "aadb[]";
                    hiddenInput.value = aadbId;
                    hiddenInput.id = "hidden-aadb-" + aadbId;
                    hiddenContainer.appendChild(hiddenInput);
                }
            } else {
                if (existingInput) {
                    existingInput.remove();
                }
            }
        }
    });
</script>
@endsection
@endsection
