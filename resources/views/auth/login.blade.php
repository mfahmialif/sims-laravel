<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template') }}/assets/img/favicon.png">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/bootstrap.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/feather.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/style.css">

</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper login-body">
        <div class="container-fluid px-0">
            <div class="row">

                <!-- Login logo -->
                <div class="col-lg-6 login-wrap">
                    <div class="login-sec">
                        <div class="log-img">
                            <img class="img-fluid" src="{{ asset('template') }}/assets/img/login-02.png" alt="Logo">
                        </div>
                    </div>
                </div>
                <!-- /Login logo -->

                <!-- Login Content -->
                <div class="col-lg-6 login-wrap-bg">
                    <div class="login-wrapper">
                        <div class="loginbox">
                            <div class="login-right">
                                <div class="login-right-wrap">
                                    <div class="account-logo">
                                        <a href="{{ route('login') }}"><img
                                                src="{{ asset('template') }}/assets/img/login-logo.png"
                                                alt=""></a>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <h2>Login</h2>
                                    <!-- Form -->
                                    <form method="POST" action="{{ route('login') }}" onsubmit="login()">
                                        @csrf
                                        <div class="input-block">
                                            <label>Username <span class="login-danger">*</span></label>
                                            <input class="form-control" type="text" name="username" required>
                                        </div>
                                        <div class="input-block">
                                            <label>Password <span class="login-danger">*</span></label>
                                            <input class="form-control pass-input" type="password" name="password"
                                                required>
                                            <span class="profile-views feather-eye-off toggle-password"></span>
                                        </div>
                                        <div class="input-block login-btn">
                                            <button id="login-button" class="btn btn-primary btn-block" type="submit">
                                                <span class="spinner-border spinner-border-sm d-none me-1"
                                                    role="status" aria-hidden="true"></span>
                                                <span class="btn-text">Login</span>
                                            </button>
                                        </div>
                                    </form>
                                    <!-- /Form -->

                                    <div class="next-sign">
                                        <p class="account-subtitle">Butuh bantuan untuk login? <u>Hubungi Operator</u>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /Login Content -->

            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('template') }}/assets/js/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('template') }}/assets/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Js -->
    <script src="{{ asset('template') }}/assets/js/feather.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('template') }}/assets/js/app.js"></script>

    <script>
        function login() {
            const btn = document.getElementById('login-button');
            const spinner = btn.querySelector('.spinner-border');
            const text = btn.querySelector('.btn-text');

            // Tampilkan spinner dan ubah state tombol
            spinner.classList.remove('d-none');
            text.textContent = 'Logging in...';
            btn.disabled = true;

            return true; // lanjutkan submit
        }
    </script>
</body>

</html>
