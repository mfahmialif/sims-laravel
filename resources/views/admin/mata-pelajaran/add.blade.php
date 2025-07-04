@extends('layouts.admin.template')
@section('title', 'Tambah Data Kelas')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.mata-pelajaran.index') }}">Mata Pelajaran</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Tambah Mata Pelajaran</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.mata-pelajaran.store') }}" onsubmit="submitForm(this)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Tambah Data Mata Pelajaran</h4>
                                </div>
                            </div>
                            @include('admin.mata-pelajaran.form')

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
