@extends('layouts.admin.template')
@section('title', 'Tambah Data Jadwal')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.jadwal.detail.index', ['kurikulumDetail' => $kurikulumDetail, 'tahunPelajaran' => $tahunPelajaran]) }}">Detail
                            Jadwal
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Tambah Jadwal</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info d-flex align-items-start gap-3" role="alert">
                <i class="feather-info mt-1"></i>
                <div>
                    <strong>Informasi:</strong><br>
                    Anda sedang menambahkan jadwal untuk mata pelajaran: <br>
                    <strong>{{ $kurikulumDetail->mataPelajaran->kode }} /
                        {{ $kurikulumDetail->mataPelajaran->nama }}</strong><br>
                    Kelas: <strong>{{ $kurikulumDetail->mataPelajaran->kelas->angka ?? '-' }}</strong>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ route('admin.jadwal.detail.store', ['kurikulumDetail' => $kurikulumDetail, 'tahunPelajaran' => $tahunPelajaran]) }}"
                        onsubmit="submitForm(this)" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Tambah Jadwal</h4>
                                </div>
                            </div>
                            @include('admin.jadwal.detail.form')

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
