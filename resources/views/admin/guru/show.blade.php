@extends('layouts.admin.template')
@section('title', 'Guru Show')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.guru.index') }}">Guru </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Data Guru</li>
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
                                <h4>Guru <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h4>
                            </div>
                            <div class="doctor-profile-head">
                                <div class="profile-bg-img">
                                    <img src="{{ asset('template') }}/assets/img/user-profile-header-bg.png" alt="Profile">
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="profile-user-box">
                                            <div class="profile-user-img">
                                                @if ($guru->foto)
                                                    <img src="{{ asset('foto_guru/' . $guru->foto) }}"
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
                                                <h4>{{ $guru->nama }}</h4>
                                                <h5>{{ ucfirst($guru->user->role->nama) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "col-lg-4 col-md-4 d-flex align-items-center">
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center">
                                        <div class="follow-btn-group">
                                            <a href="{{ route('admin.guru.edit', $guru->id) }}"
                                                class="btn btn-info follow-btns">Edit</a>
                                            <a href="{{ route('admin.profile.index') }}" type="submit"
                                                class="btn btn-info message-btns">Profile</a>
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
                    <div class="doctor-personals-grp">
                        <div class="card">
                            <div class="card-body">
                                <div class="heading-detail ">
                                    <h4 class="mb-3">Tentang Saya</h4>
                                    <p>Saya adalah {{ $guru->nama }} seorang guru</p>
                                </div>
                                <div class="about-me-list">
                                    <ul class="list-space">
                                        <li>
                                            <h4>Jenis Kelamin</h4><span>{{ $guru->jenis_kelamin }}</span>
                                        </li>
                                        <li>
                                            <h4>Agama</h4><span>{{ $guru->agama }}</span>
                                        </li>
                                        <li>
                                            <h4>Tempat, Tanggal Lahir</h4><span>{{ $guru->tempat_lahir }},
                                                {{ $guru->tanggal_lahir }}</span>
                                        </li>
                                        <li>
                                            <h4>Kewarganegaraan</h4><span>{{ $guru->kewarganegaraan }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion" class="custom-faq mb-3">
                        <div class="card mb-1">
                            <div class="card-header" id="headingTwo">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseTwo"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Data Pribadi & Identitas
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>Nama Lengkap</h4><span>{{ $guru->nama }}</span>
                                            </li>
                                            <li>
                                                <h4>NIP</h4><span>{{ $guru->nip }}</span>
                                            </li>
                                            <li>
                                                <h4>NIK</h4><span>{{ $guru->nik }}</span>
                                            </li>
                                            <li>
                                                <h4>No. KK</h4><span>{{ $guru->no_kk }}</span>
                                            </li>
                                            <li>
                                                <h4>NUPTK</h4><span>{{ $guru->nuptk }}</span>
                                            </li>
                                            <li>
                                                <h4>NPWP</h4><span>{{ $guru->npwp }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header" id="headingThree">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseThree"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Data Kepegawaian
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>Status Kepegawaian</h4><span>{{ $guru->status_kepegawaian }}</span>
                                            </li>
                                            <li>
                                                <h4>Jenis PTK</h4><span>{{ $guru->jenis_ptk }}</span>
                                            </li>
                                            <li>
                                                <h4>No. SK CPNS</h4><span>{{ $guru->no_sk_cpns }}</span>
                                            </li>
                                            <li>
                                                <h4>Tanggal CPNS</h4><span>{{ $guru->tanggal_cpns }}</span>
                                            </li>
                                            <li>
                                                <h4>No. SK Pengangkatan</h4><span>{{ $guru->no_sk_pengangkatan }}</span>
                                            </li>
                                            <li>
                                                <h4>TMT Pengangkatan</h4><span>{{ $guru->tmt_pengangkatan }}</span>
                                            </li>
                                            <li>
                                                <h4>Lembaga Pengangkatan</h4><span>{{ $guru->lembaga_pengangkatan }}</span>
                                            </li>
                                            <li>
                                                <h4>Pangkat/Golongan</h4><span>{{ $guru->pangkat_golongan }}</span>
                                            </li>
                                            <li>
                                                <h4>Tugas Tambahan</h4><span>{{ $guru->tugas_tambahan }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <div class="card-header" id="headingFour">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseFour"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Alamat Lengkap
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="collapseFour"
                                data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>Alamat Jalan</h4><span>{{ $guru->alamat_jalan }}</span>
                                            </li>
                                            <li>
                                                <h4>RT/RW</h4><span>{{ $guru->rt }}/{{ $guru->rw }}</span>
                                            </li>
                                            <li>
                                                <h4>Nama Dusun</h4><span>{{ $guru->nama_dusun }}</span>
                                            </li>
                                            <li>
                                                <h4>Desa/Kelurahan</h4><span>{{ $guru->desa_kelurahan }}</span>
                                            </li>
                                            <li>
                                                <h4>Kecamatan</h4><span>{{ $guru->kecamatan }}</span>
                                            </li>
                                            <li>
                                                <h4>Kabupaten</h4><span>{{ $guru->kabupaten }}</span>
                                            </li>
                                            <li>
                                                <h4>Provinsi</h4><span>{{ $guru->provinsi }}</span>
                                            </li>
                                            <li>
                                                <h4>Kode Pos</h4><span>{{ $guru->kodepos }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <div class="card-header" id="headingFive">
                                <h5 class="accordion-faq m-0">
                                    <a class="text-dark" data-bs-toggle="collapse" href="#collapseFive"
                                        aria-expanded="false">
                                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                                        Data Akun & Kontak
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="collapseFive"
                                data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="about-me-list">
                                        <ul class="list-space">
                                            <li>
                                                <h4>Email</h4><span>{{ $guru->email }}</span>
                                            </li>
                                            <li>
                                                <h4>No. HP</h4><span>{{ $guru->no_hp }}</span>
                                            </li>
                                            <li>
                                                <h4>Status Akun</h4><span>{{ $guru->status }}</span>
                                            </li>
                                            <li>
                                                <h4>Username</h4><span>{{ $guru->user->username }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end #accordions-->

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
                                                <th>Mata Pelajaran</th>
                                                <th>Jadwal</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < $jadwal->count(); $i++)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $jadwal[$i]->kelasSub->kelas->angka }}
                                                            {{ $jadwal[$i]->kelasSub->sub }}</td>
                                                        <td>
                                                            <div class="fw-bold">
                                                                {{ $jadwal[$i]->kurikulumDetail->mataPelajaran->kode }} /
                                                                {{ $jadwal[$i]->kurikulumDetail->mataPelajaran->nama }}
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ $jadwal[$i]->kurikulumDetail->kurikulum->nama }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold">{{ $jadwal[$i]->hari }}</div>
                                                            <small class="text-muted">{{ $jadwal[$i]->jam_mulai }} -
                                                                {{ $jadwal[$i]->jam_selesai }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="fa fa-ellipsis-v"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.kelas.sub.siswa.index', ['kelas' => $jadwal[$i]->kelasSub->kelas, 'kelasSub' => $jadwal[$i]->kelasSub]) }}"><i
                                                                            class="fa-solid fa-user m-r-5"></i> Siswa</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.absensi.rekap.index', ['jadwal' => $jadwal[$i]]) }}"><i
                                                                            class="fa-solid fa-clock m-r-5"></i>
                                                                        Absensi</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.nilai.bobot-nilai.index', ['jadwal' => $jadwal[$i]]) }}"><i
                                                                            class="fa-solid fa-chart-line m-r-5"></i>
                                                                        Bobot Nilai</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.nilai.input.index', ['jadwal' => $jadwal[$i]]) }}"><i
                                                                            class="fa-solid fa-chart-line m-r-5"></i>
                                                                        Input Nilai</a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
