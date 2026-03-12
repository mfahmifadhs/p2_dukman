<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DITJEN P2</title>

    <link rel="icon" type="image/png" href="{{ asset('dist/img/logo-kemenkes-icon.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f7f6;
            font-family: 'Segoe UI', sans-serif;
        }

        /* layout */

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* left section */

        .login-left {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .login-left h1 {
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .login-left p {
            opacity: .9;
        }

        /* right section */

        .login-right {
            padding: 60px 50px;
        }

        /* input */

        .input-group {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 6px 15px;
            background: #f9fafb;
        }

        .input-group:focus-within {
            border-color: #14b8a6;
            box-shadow: 0 0 0 0.2rem rgba(20, 184, 166, .15);
            background: #fff;
        }

        .form-control {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 12px;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #6c757d;
        }

        /* button */

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            font-weight: 600;
            letter-spacing: .5px;
            transition: .3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* logo */

        .logo-login {
            width: 160px;
            margin-bottom: 20px;
        }

        /* footer */

        .login-footer {
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        .login-footer a {
            text-decoration: none;
            color: #0f766e;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="login-wrapper">

            <div class="row g-0">

                <!-- LEFT -->

                <div class="col-lg-6 d-none d-lg-block">

                    <div class="login-left">

                        <img src="{{ url('dist/img/logo-p2.png') }}" class="logo-login">

                        <h5>
                            Sistem Manajemen Opersional Perkantoran.
                            <small class="text-light">Direktorat Jenderal Penanggulangan Penyakit</small>
                        </h5>

                    </div>

                </div>

                <!-- RIGHT -->

                <div class="col-lg-6">

                    <div class="login-right">

                        <h4 class="mb-4 fw-bold">Login Sistem</h4>

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success mb-3">
                            {{ $message }}
                        </div>
                        @endif

                        @if ($message = Session::get('failed'))
                        <div class="alert alert-danger mb-3">
                            {{ $message }}
                        </div>
                        @endif

                        <form action="{{ route('loginPost') }}" method="POST">
                            @csrf

                            <div class="input-group mb-4">

                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>

                                <input type="text" name="username" class="form-control" placeholder="Username" required>

                            </div>

                            <div class="input-group mb-4">

                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>

                                <input type="password" name="password" id="password_input" class="form-control" placeholder="Password" required>

                                <span class="input-group-text">

                                    <a href="#" onclick="togglePassword()" class="text-muted">
                                        <i class="fa fa-eye-slash" id="toggleIcon"></i>
                                    </a>

                                </span>

                            </div>

                            <button type="submit" class="btn-login">
                                Login Sekarang <i class="fa fa-arrow-right ms-2"></i>
                            </button>

                        </form>

                        <div class="login-footer text-center">

                            <p class="mt-3 mb-1">
                                <a href="#">Lupa Password?</a>
                            </p>

                            <p>
                                Butuh bantuan?
                                <a href="https://wa.me/6285772652563">Hubungi IT</a>
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {

            const passwordInput = document.getElementById("password_input");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }

        }
    </script>

</body>

</html>