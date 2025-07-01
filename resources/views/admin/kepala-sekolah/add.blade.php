@extends('layouts.admin.template')
@section('title', 'Tambah Data Kepala Sekolah')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kepala-sekolah.index') }}">Kepala Sekolah </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Tambah Kepala Sekolah</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kepala-sekolah.store') }}" id="form-add" onsubmit="submitForm(this)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Tambah Data Kepala Sekolah</h4>
                                </div>
                            </div>
                            @include('admin.kepala-sekolah.form')

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
