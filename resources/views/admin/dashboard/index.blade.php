@extends('layouts.admin.template')
@section('title', 'Dashboard')
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Akademik Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="good-morning-blk">
        <div class="row">
            <div class="col-md-6">
                <div class="morning-user">
                    <h2>Selamat Pagi, <span>Admin</span></h2>
                    <p>Selamat datang di Sistem Informasi Manajemen Siswa</p>
                </div>
            </div>
            <div class="col-md-6 position-blk">
                <div class="morning-img">
                    <img src="{{ asset('template') }}/assets/img/morning-img-01.png" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-boxs comman-flex-center">
                    <img src="{{ asset('template') }}/assets/img/icons/calendar.svg" alt="">
                </div>
                <div class="dash-content dash-count">
                    <h4>Total Siswa</h4>
                    <h2><span class="counter-up">{{ $siswa }}</span></h2>
                    <p><span class="passive-view">Siswa</span> {{ env('NAMA_SEKOLAH') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-boxs comman-flex-center">
                    <img src="{{ asset('template') }}/assets/img/icons/profile-add.svg" alt="">
                </div>
                <div class="dash-content dash-count">
                    <h4>Total Guru</h4>
                    <h2><span class="counter-up">{{ $guru }}</span></h2>
                    <p><span class="passive-view">Guru</span> pengajar</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-boxs comman-flex-center">
                    <img src="{{ asset('template') }}/assets/img/icons/scissor.svg" alt="">
                </div>
                <div class="dash-content dash-count">
                    <h4>Total Kelas</h4>
                    <h2><span class="counter-up">{{ $kelasSub }}</span></h2>
                    <p><span class="passive-view">Sub</span> Kelas</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-boxs comman-flex-center">
                    <img src="{{ asset('template') }}/assets/img/icons/empty-wallet.svg" alt="">
                </div>
                <div class="dash-content dash-count">
                    <h4>Jadwal</h4>
                    <h2><span class="counter-up">{{ $jadwal }}</span></h2>
                    <p><span class="passive-view">Jadwal</span> mata pelajaran</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="chart-title patient-visit">
                        <h4>Statistik Kehadiran Siswa</h4>
                    </div>
                    <div id="statistik"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const series = @json($series);
        const xaxis = @json($xaxis);
        if ($('#statistik').length > 0) {
            var sColStacked = {
                chart: {
                    height: 230,
                    type: 'bar',
                    stacked: true,
                    toolbar: {
                        show: false,
                    }
                },
                // colors: ['#4361ee', '#888ea8', '#e3e4eb', '#d3d3d3'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '15%'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                series: series,
                xaxis: xaxis,

            }

            var chart = new ApexCharts(
                document.querySelector("#statistik"),
                sColStacked
            );

            chart.render();
        }
    </script>
@endpush
