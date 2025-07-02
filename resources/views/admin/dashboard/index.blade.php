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
                    <h2><span class="counter-up">850</span></h2>
                    <p><span class="passive-view"><i class="feather-arrow-up-right me-1"></i>15%</span> vs bulan lalu</p>
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
                    <h2><span class="counter-up">50</span></h2>
                    <p><span class="passive-view"><i class="feather-arrow-up-right me-1"></i>10%</span> vs bulan lalu</p>
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
                    <h2><span class="counter-up">24</span></h2>
                    <p><span class="passive-view"><i class="feather-arrow-up-right me-1"></i>5%</span> vs bulan lalu</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-boxs comman-flex-center">
                    <img src="{{ asset('template') }}/assets/img/icons/empty-wallet.svg" alt="">
                </div>
                <div class="dash-content dash-count">
                    <h4>Pembayaran SPP</h4>
                    <h2>Rp<span class="counter-up"> 125.000.000</span></h2>
                    <p><span class="passive-view"><i class="feather-arrow-up-right me-1"></i>20%</span> vs bulan lalu</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 col-lg-6 col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="chart-title patient-visit">
                        <h4>Statistik Kehadiran Siswa</h4>
                        <div>
                            <ul class="nav chat-user-total">
                                <li><i class="fa fa-circle current-users" aria-hidden="true"></i>Hadir 90%</li>
                                <li><i class="fa fa-circle old-users" aria-hidden="true"></i> Tidak Hadir 10%</li>
                            </ul>
                        </div>
                        <div class="input-block mb-0">
                            <select class="form-control select">
                                <option>2025</option>
                                <option>2024</option>
                                <option>2023</option>
                                <option>2022</option>
                            </select>
                        </div>
                    </div>
                    <div id="patient-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6 col-xl-3 d-flex">
            <div class="card">
                <div class="card-body">
                    <div class="chart-title">
                        <h4>Diagram Siswa</h4>
                    </div>
                    <div id="donut-chart-dash" class="chart-user-icon">
                        <img src="{{ asset('template') }}/assets/img/icons/user-icon.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12  col-xl-4">
            <div class="card top-departments">
                <div class="card-header">
                    <h4 class="card-title mb-0">Jurusan</h4>
                </div>
                <div class="card-body">
                    <div class="activity-top">
                        <div class="activity-boxs comman-flex-center">
                            <img src="{{ asset('template') }}/assets/img/icons/dep-icon-01.svg" alt="">
                        </div>
                        <div class="departments-list">
                            <h4>IPA</h4>
                            <p>35%</p>
                        </div>
                    </div>
                    <div class="activity-top">
                        <div class="activity-boxs comman-flex-center">
                            <img src="{{ asset('template') }}/assets/img/icons/dep-icon-02.svg" alt="">
                        </div>
                        <div class="departments-list">
                            <h4>IPS</h4>
                            <p>30%</p>
                        </div>
                    </div>
                    <div class="activity-top">
                        <div class="activity-boxs comman-flex-center">
                            <img src="{{ asset('template') }}/assets/img/icons/dep-icon-03.svg" alt="">
                        </div>
                        <div class="departments-list">
                            <h4>Bahasa</h4>
                            <p>20%</p>
                        </div>
                    </div>
                    <div class="activity-top">
                        <div class="activity-boxs comman-flex-center">
                            <img src="{{ asset('template') }}/assets/img/icons/dep-icon-04.svg" alt="">
                        </div>
                        <div class="departments-list">
                            <h4>Multimedia</h4>
                            <p>15%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12  col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-inline-block">Data Guru / Kepala Sekolah</h4>
                </div>
                <div class="card-body p-0 table-dash">
                    <div class="table-responsive">
                        <table class="table mb-0 border-0 datatable custom-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Budi Santoso, S.Pd</td>
                                    <td>19751231 200501 1 001</td>
                                    <td>Guru</td>
                                    <td>Matematika</td>
                                    <td><span class="custom-badge status-green">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Sri Wahyuni, M.Pd</td>
                                    <td>19780115 200604 2 002</td>
                                    <td>Kepala Sekolah</td>
                                    <td>-</td>
                                    <td><span class="custom-badge status-green">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Agus Prasetyo, S.Pd</td>
                                    <td>19800220 200807 1 003</td>
                                    <td>Guru</td>
                                    <td>Fisika</td>
                                    <td><span class="custom-badge status-green">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Rina Marlina, S.Pd</td>
                                    <td>19850510 201001 2 004</td>
                                    <td>Guru</td>
                                    <td>Bahasa Indonesia</td>
                                    <td><span class="custom-badge status-green">Aktif</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

