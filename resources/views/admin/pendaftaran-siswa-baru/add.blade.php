@extends('layouts.admin.template')
@section('title', 'Pendaftaran Siswa Baru')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.pendaftaran-siswa-baru.index') }}">User </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Pendaftaran Siswa Baru</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.pendaftaran-siswa-baru.store') }}" onsubmit="submitForm(this)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Pendaftaran Siswa Baru</h4>
                                </div>
                            </div>
                            @include('admin.pendaftaran-siswa-baru.form')

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
