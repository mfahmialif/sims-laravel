<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template') }}/assets/img/favicon.png">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/bootstrap.min.css">

    <!-- Jquery UI CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/jquery-ui.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/fontawesome/css/all.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/select2.min.css">

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/toastr-new/toastr.min.css">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/datatables/datatables.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/feather.css">

    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/custom.css">

    <style>
        .form-title {
            margin-bottom: 24px;
        }
    </style>
</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper login-body">
        <div class="container-fluid px-0">
            <div class="row">


                <!-- Login Content -->
                <div class="col-lg-12 login-wrap-bg">
                    <div class="login-wrapper">
                        <div class="loginbox">
                            <div class="login-right">
                                <div class="login-right-wrap">

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <h2>Register</h2>
                                    <!-- Form -->
                                    <form method="POST" action="{{ route('register') }}" onsubmit="register()" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            @include('auth.register.form')

                                        </div>
                                    </form>
                                    <!-- /Form -->

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
    <script src="{{ asset('template') }}/assets/js/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('template') }}/assets/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Js -->
    <script src="{{ asset('template') }}/assets/js/feather.min.js"></script>

    <!-- Slimscroll -->
    <script src="{{ asset('template') }}/assets/js/jquery.slimscroll.js"></script>

    <!-- Select2 Js -->
    <script src="{{ asset('template') }}/assets/js/select2.min.js"></script>

    <!-- Datatables JS -->
    <script src="{{ asset('template') }}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template') }}/assets/plugins/datatables/datatables.min.js"></script>

    <!-- counterup JS -->
    <script src="{{ asset('template') }}/assets/js/jquery.waypoints.js"></script>
    <script src="{{ asset('template') }}/assets/js/jquery.counterup.min.js"></script>

    <!-- Apexchart JS -->
    <script src="{{ asset('template') }}/assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ asset('template') }}/assets/plugins/apexchart/chart-data.js"></script>

    <!-- Datepicker Core JS -->
    <script src="{{ asset('template') }}/assets/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="{{ asset('template') }}/assets/plugins/toastr-new/toastr.min.js"></script>
    <script src="{{ asset('template') }}/assets/plugins/sweetalert-1/sweetalert.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('template') }}/assets/js/toastrconfig.js"></script>
    <script src="{{ asset('template') }}/assets/js/custom.js"></script>
    <script src="{{ asset('template') }}/assets/js/app.js"></script>

    <script>
        function register() {
            const btn = document.getElementById('register-button');
            const spinner = btn.querySelector('.spinner-border');
            const text = btn.querySelector('.btn-text');

            // Tampilkan spinner dan ubah state tombol
            spinner.classList.remove('d-none');
            text.textContent = 'Process Register...';
            btn.disabled = true;

            return true; // lanjutkan submit
        }

        function handleFileUpload(input, fileInfoId, uploadLabelId) {
            const fileInfo = document.getElementById(fileInfoId);
            const uploadLabel = document.getElementById(uploadLabelId);
            const file = input.files[0];

            if (file) {
                const isImage = file.type.startsWith("image/");
                if (!isImage) {
                    fileInfo.innerText = "Belum ada file";
                    uploadLabel.innerText = "Pilih File";
                    return;
                }

                fileInfo.innerText = file.name;
                uploadLabel.innerText = file.name;
            } else {
                fileInfo.innerText = "Belum ada file";
                uploadLabel.innerText = "Pilih File";
            }
        }
    </script>
</body>

</html>
