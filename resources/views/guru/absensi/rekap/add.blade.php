@extends('layouts.admin.template')
@section('title', 'Tambah Data Absensi')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('guru.absensi.index') }}">Absensi </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a href="{{ route('guru.absensi.rekap.index', ['jadwal' => $jadwal]) }}">Rekap </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Tambah Absensi</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guru.absensi.rekap.store', ['jadwal' => $jadwal]) }}" onsubmit="submitForm(this)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Tambah Data Absensi</h4>
                                </div>
                            </div>
                            @include('guru.absensi.rekap.form', [
                                'url' => route('guru.absensi.rekap.data-form', ['jadwal' => $jadwal]),
                            ])

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#tanggal').val("{{ date('Y-m-d') }}");
    </script>
@endpush
