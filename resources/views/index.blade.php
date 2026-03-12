<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DITJEN P2</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet">

</head>

<body>


    <!-- NAVBAR -->

    <div class="container-fluid sticky-top bg-white">
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-light">

                <a href="#" class="navbar-brand">
                    <img src="{{ asset('dist/img/logo-p2.png') }}" height="45">
                </a>

                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">

                    <div class="navbar-nav ms-auto">

                        <a href="#" class="nav-item nav-link active">Home</a>
                        <a href="#" class="nav-item nav-link">About</a>
                        <a href="#" class="nav-item nav-link">Services</a>
                        <a href="#" class="nav-item nav-link">Projects</a>

                        <div class="nav-item dropdown">

                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>

                            <div class="dropdown-menu">

                                <a href="#" class="dropdown-item">Features</a>
                                <a href="#" class="dropdown-item">Our Team</a>
                                <a href="#" class="dropdown-item">Testimonial</a>

                            </div>

                        </div>

                        <a href="#" class="nav-item nav-link">Contact</a>

                    </div>
                </div>

            </nav>

        </div>
    </div>


    <!-- HERO -->

    <div class="container-fluid hero-header">

        <div class="container">

            <div class="row g-4 align-items-center">

                <!-- TEXT -->

                <div class="col-lg-6">

                    <h1 class="hero-title animated slideInRight">
                        Sistem Manajemen <span class="text-primary">Opersional Perkantoran</span>
                    </h1>

                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Login Sistem
                        </a>
                    </div>

                </div>


                <!-- IMAGE SLIDER -->

                <div class="col-lg-6">

                    <div class="owl-carousel header-carousel animated fadeIn">

                        <img class="img-fluid" src="{{ asset('dist/img/main/hero-slider-1.jpg') }}">

                        <img class="img-fluid" src="{{ asset('dist/img/main/hero-slider-2.jpg') }}">

                        <img class="img-fluid" src="{{ asset('dist/img/main/hero-slider-3.jpg') }}">

                    </div>

                </div>

            </div>


            <!-- FEATURES -->

            <div class="row g-3 mt-4">

                <div class="col-md-6 col-lg-3">

                    <div class="feature-box">

                        <div class="btn-square border border-2 border-white me-3">
                            <i class="fa fa-robot text-primary"></i>
                        </div>

                        <h6 class="mb-0">Crafted Furniture</h6>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="feature-box">

                        <div class="btn-square border border-2 border-white me-3">
                            <i class="fa fa-robot text-primary"></i>
                        </div>

                        <h6 class="mb-0">Sustainable Material</h6>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="feature-box">

                        <div class="btn-square border border-2 border-white me-3">
                            <i class="fa fa-robot text-primary"></i>
                        </div>

                        <h6 class="mb-0">Innovative Architects</h6>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="feature-box">

                        <div class="btn-square border border-2 border-white me-3">
                            <i class="fa fa-robot text-primary"></i>
                        </div>

                        <h6 class="mb-0">Budget Friendly</h6>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- BACK TO TOP -->

    <a href="#" class="btn btn-primary btn-lg-square back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>


    <!-- JS -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('dist/js/wow.js') }}"></script>
    <script src="{{ asset('dist/js/owl.carousel.js') }}"></script>

    <script>
        $(document).ready(function() {

            $(".header-carousel").owlCarousel({

                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                smartSpeed: 1000

            });

        });
    </script>

</body>

</html>