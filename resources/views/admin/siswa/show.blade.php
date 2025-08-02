@extends('layouts.admin.template')
@section('title', 'Siswa Show')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Siswa </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Data Siswa</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-info">
                                <h4>Profil Siswa <span><a href="javascript:;"><i
                                                class="feather-more-vertical"></i></a></span></h4>

                            </div>
                            <div class="doctor-profile-head">
                                <div class="profile-bg-img">
                                    <img src="{{ asset('template') }}/assets/img/user-profile-header-bg.png" alt="Profile">
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="profile-user-box">
                                            <div class="profile-user-img">
                                                @if ($siswa->foto)
                                                    <img src="{{ asset('foto_siswa/' . $siswa->foto) }}"
                                                        style="height: 100px !important; width: 100px !important"
                                                        alt="Profile">
                                                @else
                                                    <img src="{{ asset('template') }}/assets/img/profile-user.jpg"
                                                        alt="Profile"
                                                        style="height: 100px !important; width: 100px !important">
                                                @endif
                                                <div class="input-block doctor-up-files profile-edit-icon mb-0">
                                                    <div class="uplod d-flex">
                                                        <label class="file-upload profile-upbtn mb-0">
                                                            <img src="{{ asset('template') }}/assets/img/icons/camera-icon.svg"
                                                                alt="Profile"></i><input type="file">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="names-profiles">
                                                <h4>{{ $siswa->nama_siswa }}</h4>
                                                <h5>{{ ucfirst($siswa->user->role->nama) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "col-lg-4 col-md-4 d-flex align-items-center">
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center">
                                        <div class="follow-btn-group">
                                            <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                                class="btn btn-info follow-btns">Edit</a>
                                            <a href="#akademik" class="btn btn-info message-btns">Akademik</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="doctor-personals-grp mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="heading-detail ">
                                    <h4 class="mb-3">Tentang Saya</h4>
                                    <p>Saya adalah {{ $siswa->nama_siswa }} seorang siswa</p>
                                </div>
                                <div class="about-me-list">
                                    <ul class="list-space">
                                        <li>
                                            <h4>Jenis Kelamin</h4><span>{{ $siswa->jenis_kelamin }}</span>
                                        </li>
                                        <li>
                                            <h4>Agama</h4><span>{{ $siswa->agama }}</span>
                                        </li>
                                        <li>
                                            <h4>Tempat, Tanggal Lahir</h4><span>{{ $siswa->tempat_lahir }},
                                                {{ $siswa->tanggal_lahir }}</span>
                                        </li>
                                        <li>
                                            <h4>Golongan Darah</h4><span>{{ $siswa->gol_darah }}</span>
                                        </li>
                                        <li>
                                            <h4>Foto</h4><span>
                                                @if ($siswa->foto)
                                                    <img src="{{ asset('foto_siswa/' . $siswa->foto) }}"
                                                        style="height:40px;width:40px">
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion" class="custom-faq mb-3">
                        <!-- Data Pribadi & Identitas -->
                        <div class="card mb-1">
                            <div class="card-header" id="headingIdentitas">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseIdentitas"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Data Pribadi & Identitas
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseIdentitas" class="collapse" aria-labelledby="headingIdentitas"
                                data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>NIS</h4><span>{{ $siswa->nis }}</span>
                                            </li>
                                            <li>
                                                <h4>NISN</h4><span>{{ $siswa->nisn }}</span>
                                            </li>
                                            <li>
                                                <h4>Nama Siswa</h4><span>{{ $siswa->nama_siswa }}</span>
                                            </li>
                                            <li>
                                                <h4>Tempat, Tanggal Lahir</h4><span>{{ $siswa->tempat_lahir }},
                                                    {{ $siswa->tanggal_lahir }}</span>
                                            </li>
                                            <li>
                                                <h4>Agama</h4><span>{{ $siswa->agama }}</span>
                                            </li>
                                            <li>
                                                <h4>Golongan Darah</h4><span>{{ $siswa->gol_darah }}</span>
                                            </li>
                                            <li>
                                                <h4>Foto</h4><span>
                                                    @if ($siswa->foto)
                                                        <img src="{{ asset('foto_siswa/' . $siswa->foto) }}"
                                                            style="height:40px;width:40px">
                                                    @endif
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="card mb-1">
                            <div class="card-header" id="headingAlamat">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseAlamat"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Alamat Lengkap
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseAlamat" class="collapse" aria-labelledby="headingAlamat"
                                data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>Alamat Anak Sesuai KK</h4>
                                                <span>{{ $siswa->alamat_anak_sesuai_kk }}</span>
                                            </li>
                                            <li>
                                                <h4>Desa/Kelurahan</h4><span>{{ $siswa->desa_kelurahan_anak }}</span>
                                            </li>
                                            <li>
                                                <h4>Kecamatan</h4><span>{{ $siswa->kecamatan_anak }}</span>
                                            </li>
                                            <li>
                                                <h4>Kabupaten</h4><span>{{ $siswa->kabupaten_anak }}</span>
                                            </li>
                                            <li>
                                                <h4>Kode Pos</h4><span>{{ $siswa->kode_pos_anak }}</span>
                                            </li>
                                            <li>
                                                <h4>RT/RW</h4><span>{{ $siswa->rt_anak }}/{{ $siswa->rw_anak }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Orang Tua -->
                        <div class="card mb-1">
                            <div class="card-header" id="headingOrtu">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseOrtu"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Data Orang Tua
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseOrtu" class="collapse" aria-labelledby="headingOrtu"
                                data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>Nama Ayah</h4><span>{{ $siswa->nama_ayah }}</span>
                                            </li>
                                            <li>
                                                <h4>NIK Ayah</h4><span>{{ $siswa->nik_ayah }}</span>
                                            </li>
                                            <li>
                                                <h4>Tahun Lahir Ayah</h4><span>{{ $siswa->tahun_lahir_ayah }}</span>
                                            </li>
                                            <li>
                                                <h4>Pendidikan Ayah</h4><span>{{ $siswa->pendidikan_ayah }}</span>
                                            </li>
                                            <li>
                                                <h4>Pekerjaan Ayah</h4><span>{{ $siswa->pekerjaan_ayah }}</span>
                                            </li>
                                            <li>
                                                <h4>Penghasilan Bulanan Ayah</h4>
                                                <span>{{ $siswa->penghasilan_bulanan_ayah }}</span>
                                            </li>
                                            <li>
                                                <h4>Nama Ibu</h4><span>{{ $siswa->nama_ibu_sesuai_ktp }}</span>
                                            </li>
                                            <li>
                                                <h4>NIK Ibu</h4><span>{{ $siswa->nik_ibu }}</span>
                                            </li>
                                            <li>
                                                <h4>Tahun Lahir Ibu</h4><span>{{ $siswa->tahun_lahir_ibu }}</span>
                                            </li>
                                            <li>
                                                <h4>Pendidikan Ibu</h4><span>{{ $siswa->pendidikan_ibu }}</span>
                                            </li>
                                            <li>
                                                <h4>Pekerjaan Ibu</h4><span>{{ $siswa->pekerjaan_ibu }}</span>
                                            </li>
                                            <li>
                                                <h4>Penghasilan Bulanan Ibu</h4>
                                                <span>{{ $siswa->penghasilan_bulanan_ibu }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Wali -->
                        <div class="card mb-1">
                            <div class="card-header" id="headingWali">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseWali"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Data Wali
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseWali" class="collapse" aria-labelledby="headingWali"
                                data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>Nama Wali</h4><span>{{ $siswa->nama_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>NIK Wali</h4><span>{{ $siswa->nik_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Tahun Lahir Wali</h4><span>{{ $siswa->tahun_lahir_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Pendidikan Wali</h4><span>{{ $siswa->pendidikan_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Pekerjaan Wali</h4><span>{{ $siswa->pekerjaan_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Penghasilan Bulanan Wali</h4>
                                                <span>{{ $siswa->penghasilan_bulanan_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Alamat Wali</h4><span>{{ $siswa->alamat_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>RT/RW Wali</h4>
                                                <span>{{ $siswa->rt_wali }}/{{ $siswa->rw_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Desa/Kelurahan Wali</h4><span>{{ $siswa->desa_kelurahan_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Kecamatan Wali</h4><span>{{ $siswa->kecamatan_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Kabupaten Wali</h4><span>{{ $siswa->kabupaten_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Kode Pos Wali</h4><span>{{ $siswa->kode_pos_wali }}</span>
                                            </li>
                                            <li>
                                                <h4>Nomor Telepon Wali</h4><span>{{ $siswa->nomor_telepon_wali }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Akun & Kontak -->
                        <div class="card mb-1">
                            <div class="card-header" id="headingAkun">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseAkun"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Data Akun & Kontak
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseAkun" class="collapse" aria-labelledby="headingAkun"
                                data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>Status Daftar</h4><span>{{ $siswa->status_daftar }}</span>
                                            </li>
                                            <li>
                                                <h4>Status</h4><span>{{ $siswa->status }}</span>
                                            </li>
                                            <li>
                                                <h4>Username</h4><span>{{ $siswa->user->username }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end #accordion -->

                </div>
                <div class="col-lg-8">
                    <div class="doctor-personals-grp">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content-set">
                                    <ul class="nav">
                                        <li>
                                            <a href="#" class="active"><span class="set-about-icon me-2"><img
                                                        src="{{ asset('template') }}/assets/img/icons/menu-icon-02.svg"
                                                        alt=""></span>Kelas</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="hello-park">
                                    <div class="table-r esponsive">
                                        <table class="table mb-0 border-0 custom-table profile-table">
                                            <thead>
                                                <th>No.</th>
                                                <th>Kelas</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < $kelasSiswa->count(); $i++)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $kelasSiswa[$i]->kelasSub->kelas->angka }}
                                                            {{ $kelasSiswa[$i]->kelasSub->sub }}</td>
                                                        <td>
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="fa fa-ellipsis-v"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.kelas.sub.siswa.index', ['kelas' => $kelasSiswa[$i]->kelasSub->kelas, 'kelasSub' => $kelasSiswa[$i]->kelasSub]) }}"><i
                                                                            class="fa-solid fa-user m-r-5"></i> Kelas</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-white" id="akademik">
                            <div class="card-header">
                                <h5 class="card-title">Akademik</h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                                    @for ($i = 0; $i < $kelasSiswa->count(); $i++)
                                        <li class="nav-item" role="presentation"><a
                                                class="nav-link {{ $i == 0 ? 'active' : '' }}"
                                                href="#akademik-tab-{{ $i }}" data-bs-toggle="tab"
                                                aria-selected="true"
                                                role="tab">{{ $kelasSiswa[$i]->kelasSub->kelas->angka }}
                                                {{ $kelasSiswa[$i]->kelasSub->sub }}</a></li>
                                    @endfor
                                </ul>
                                <div class="tab-content">
                                    @for ($i = 0; $i < $kelasSiswa->count(); $i++)
                                        <div class="tab-pane {{ $i == 0 ? 'show active' : '' }}"
                                            id="{{ 'akademik-tab-' . $i }}" role="tabpanel">
                                            <div class="hello-park">
                                                <div class="table-r esponsive">
                                                    <table class="table mb-0 border-0 custom-table profile-table">
                                                        <thead>
                                                            <th>No.</th>
                                                            <th>Mata Pelajaran</th>
                                                            <th>Jadwal</th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $jadwal = $kelasSiswa[$i]->kelasSub->jadwal
                                                                    ->filter(function ($item) use ($siswa) {
                                                                        return $item->kurikulumDetail &&
                                                                            $item->kurikulumDetail->kurikulum_id ==
                                                                                $siswa->kurikulum_id;
                                                                    })
                                                                    ->values();
                                                            @endphp
                                                            @for ($j = 0; $j < $jadwal->count(); $j++)
                                                                <tr>
                                                                    <td>{{ $j + 1 }}</td>
                                                                    <td>{{ $jadwal[$j]->kurikulumDetail->mataPelajaran->nama }}
                                                                    </td>
                                                                    <td>
                                                                        <div class="fw-bold">
                                                                            {{ $jadwal[$j]->hari }}
                                                                        </div>
                                                                        <small
                                                                            class="text-muted">{{ date('H:i', strtotime($jadwal[$j]->jam_mulai)) }}  -
                                                                            {{ date ('H:i', strtotime($jadwal[$j]->jam_selesai)) }}</small>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown dropdown-action">
                                                                            <a href="#"
                                                                                class="action-icon dropdown-toggle"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-expanded="false"><i
                                                                                    class="fa fa-ellipsis-v"></i></a>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('admin.siswa.absensi', ['siswa' => $siswa, 'jadwal' => $jadwal[$j]]) }}"><i
                                                                                        class="fa-solid fa-clock m-r-5"></i>Absensi</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('admin.siswa.nilai', ['siswa' => $siswa, 'jadwal' => $jadwal[$j]]) }}"><i
                                                                                        class="fa-solid fa-chart-line m-r-5"></i>Nilai</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
