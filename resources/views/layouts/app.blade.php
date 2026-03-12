<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DITJEN P2</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icon Title -->
    <link rel="icon" type="image/png" href="{{ asset('dist/img/logo-kemenkes-icon.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/select2/css/select2.css') }}">
    <!-- Swal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- zoom -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    @yield('css')
</head>

<!-- <body class="hold-transition sidebar-mini sidebar-collapse"> -->

<body class="hold-transition sidebar-mini sidebar-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader">
            <div class="loader"></div>
        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user-circle"></i>
                        <b>{{ Auth::user()->pegawai->nama_pegawai }}</b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">
                            <p class="text-capitalize">
                                {{ Auth::user()->pegawai->nama_pegawai }}
                            </p>
                        </span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profil', Auth::user()->id) }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('dist/img/logo-p2.png') }}" alt="Sistem Informasi Pergudangan" class="brand-image " style="opacity: .8">
                <span class="brand-text font-weight-light">&nbsp;</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar mt-3" style="overflow-y: auto; max-height: 100vh;">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Beranda</p>
                            </a>
                        </li>

                        <li class="nav-header"><i>Alat Tulis Kantor</i></li>

                        <li class="nav-item">
                            <a href="{{ route('atk') }}" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>Permintaan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('usulan','atk') }}" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Daftar Usulan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('atk-distribusi') }}" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>Distribusi</p>
                            </a>
                        </li>

                        @if (Auth::user()->role_id == 1 || Auth::user()->akses_id == 3)
                        <li class="nav-header"><i>Master Data</i></li>
                        <li class="nav-item">
                            <a href="#" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-pencil"></i>
                                <p>
                                    Master ATK
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('atk-barang') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('atk-kategori') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ Route('atk-satuan') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Satuan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ Route('atk-stok') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Stok (Barang Masuk)</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif


                        @if (Auth::user()->role_id == 1)
                        <li class="nav-header"><i>Usulan</i></li>
                        <li class="nav-item">
                            <a href="{{ route('form') }}" class="nav-link font-weight-bold">
                                <i class="nav-icon fa-solid fa-file-lines"></i>
                                <p>Form</p>
                            </a>
                        </li>

                        <li class="nav-header"><i>Pegawai</i></li>
                        <li class="nav-item">
                            <a href="{{ route('pegawai') }}" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-users-viewfinder"></i>
                                <p>Pegawai</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('uker') }}" class="nav-link font-weight-bold">
                                <i class="nav-icon fa-solid fa-users-rectangle"></i>
                                <p>Unit Kerja</p>
                            </a>
                        </li>

                        <li class="nav-header"><i>Users</i></li>
                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link font-weight-bold">
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('akses') }}" class="nav-link font-weight-bold">
                                <i class="nav-icon fa-solid fa-users-gear"></i>
                                <p>Users Akses</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            @yield('content')
            <br>
        </div>


        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2026 <a href="#">IT Dukman Setditjen P2</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <!-- <script src="{{ asset('dist/js/jquery.min.js') }}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('dist/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('dist/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- ChartJS -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Include SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Chart -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/0.7.0/chartjs-plugin-datalabels.min.js"></script>

    <!-- zoom -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    <!-- tandatangan -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    @if (Session::has('failed'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ Session::get("failed") }}',
        });
    </script>
    @endif

    @if (Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ Session::get("success") }}',
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>
    @endif

    @yield('js')
    <script>
        $(function() {
            var url = window.location.href;

            // Untuk single sidebar menu
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');

            // Untuk sidebar menu dan treeview (buka menu jika salah satu sub-menu aktif)
            $('ul.nav-treeview a').filter(function() {
                return this.href == url;
            }).each(function() {
                $(this)
                    .addClass('active') // Tambah class active ke link yang cocok
                    .closest('.nav-treeview') // Cari elemen ul.nav-treeview terdekat
                    .css('display', 'block') // Tampilkan sub-menu
                    .closest('.nav-item') // Ambil elemen li.nav-item terdekat (parent)
                    .addClass('menu-is-opening menu-open') // Tambahkan class yang diinginkan
                    .children('a').addClass('active'); // Tambahkan class active ke parent menu utama
            });
        });

        $(document).ready(function() {
            $('.number').on('input', function() {
                // Menghapus karakter selain angka (termasuk tanda titik koma sebelumnya)
                var value = $(this).val().replace(/[^0-9]/g, '');
                // Format dengan menambahkan titik koma setiap tiga digit
                var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                $(this).val(formattedValue);
            });
        });
    </script>

    <script>
        // Password
        $(document).ready(function() {
            $(".eye-icon-pass").click(function() {
                var password = $(".password");
                var icon = $("#eye-icon-pass");
                if (password.attr("type") == "password") {
                    password.attr("type", "text");
                    icon.removeClass("fa-solid fa-eye").addClass("fa-solid fa-eye-slash");
                } else {
                    password.attr("type", "password");
                    icon.removeClass("fa-solid fa-eye-slash").addClass("fa-solid fa-eye");
                }
            });
        });
    </script>

    <script>
        function displaySelectedFile(input) {
            var selectedFileName = "";
            if (input.files.length > 0) {
                selectedFileName = input.files[0].name;
            }

            document.getElementById("selected-file-name").textContent = selectedFileName;
        }
    </script>

    <script>
        $(function() {
            $('.previewImg').change(function() {
                const previewId = $(this).data('preview'); // Ambil ID target dari data-preview
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    // Ketika file dibaca, update atribut src dari elemen target
                    reader.onload = (e) => {
                        $(`#${previewId}`).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(file); // Membaca file sebagai URL
                }
            });
        });
    </script>

    <script>
        document.querySelector('.previewImg').addEventListener('change', function(event) {
            const previewContainer = document.getElementById(this.dataset.preview);
            previewContainer.innerHTML = ''; // Bersihkan kontainer preview sebelumnya

            const files = event.target.files; // Ambil file yang diunggah
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Tambahkan elemen gambar ke kontainer preview
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview Foto";
                    img.className = "img-fluid w-25 rounded border";
                    img.style.marginRight = "10px";
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file); // Membaca file sebagai Data URL
            });
        });
    </script>

    <script>
        function confirmSubmit(event, formId) {
            event.preventDefault();

            const form = document.getElementById(formId);
            const requiredInputs = form.querySelectorAll('input[required]:not(:disabled), select[required]:not(:disabled), textarea[required]:not(:disabled)');

            let allInputsValid = true;

            requiredInputs.forEach(input => {
                if (input.value.trim() === '') {
                    input.style.borderColor = 'red';
                    allInputsValid = false;
                } else {
                    input.style.borderColor = '';
                }
            });

            if (allInputsValid) {
                Swal.fire({
                    title: 'Proses',
                    text: '',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
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

                        form.submit();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Ada input yang diperlukan yang belum diisi.',
                    icon: 'error'
                });
            }
        }
    </script>

    <script>
        function confirmLink(event, url) {
            event.preventDefault(); // Prevent the default link behavior
            Swal.fire({
                title: 'Proses',
                text: '',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal!',
            }).then((result) => {
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

                    window.location.href = url;
                }
            });
        }
    </script>

    <script>
        function confirmReusul(event, url) {
            event.preventDefault(); // Prevent the default link behavior
            Swal.fire({
                title: 'Usulkan Kembali',
                text: 'Mengusulkan kembali',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal!',
            }).then((result) => {
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

                    window.location.href = url;
                }
            });
        }
    </script>
</body>

</html>