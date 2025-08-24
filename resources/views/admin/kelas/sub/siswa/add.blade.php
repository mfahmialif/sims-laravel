@extends('layouts.admin.template')
@section('title', 'Tambah Data Siswa Kelas')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.sub.index', ['kelas' => $kelas]) }}">Sub Kelas
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active"><a
                            href="{{ route('admin.kelas.sub.siswa.index', ['kelas' => $kelas, 'kelasSub' => $kelasSub]) }}">Siswa
                            Kelas
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Tambah Data Siswa Kelas</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <form action="{{ route('admin.kelas.sub.siswa.store', ['kelas' => $kelas, 'kelasSub' => $kelasSub]) }}"
        onsubmit="submitFormThis(this)" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info d-flex align-items-center gap-2" role="alert">
                    <i class="feather-info"></i>
                    <div>
                        <strong>Informasi:</strong> Anda sedang menambahkan siswa untuk
                        <strong>Kelas {{ $kelas->angka }} ({{ $kelas->romawi }}) - {{ $kelasSub->sub }}</strong>.
                    </div>
                </div>
                <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                    <i class="feather-check"></i>
                    <div>
                        Centang untuk memilih siswa yang akan dimasukkan di kelas ini.
                    </div>
                </div>
                @include('admin.kelas.sub.siswa.form')
            </div>
        </div>
    </form>
@endsection
