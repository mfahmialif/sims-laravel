@extends('layouts.admin.template')
@section('title', 'Tambah Data Kurikulum')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kurikulum.index') }}">Kurikulum</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Tambah Kurikulum</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info" role="alert">
                Silahkan pilih tahun pelajaran terlebih dahulu.<br>
                Kemudian <b>centang mata pelajaran</b> untuk memasukkan di kurikulum.
            </div>
            <form action="{{ route('admin.kurikulum.store') }}" method="POST">
                @csrf
                @include('admin.kurikulum.form')
            </form>

        </div>
    </div>
@endsection
