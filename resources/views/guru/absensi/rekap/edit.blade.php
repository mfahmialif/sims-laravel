@extends('layouts.admin.template')
@section('title', 'Edit Data Absensi')
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
                    <li class="breadcrumb-item active">Edit Absensi</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guru.absensi.rekap.update', ['jadwal' => $jadwal, 'absensi' => $absensi]) }}" onsubmit="submitForm(this)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Absensi</h4>
                                </div>
                            </div>
                            @include('guru.absensi.rekap.form', [
                                'url' => route('guru.absensi.rekap.data-form-edit', ['jadwal' => $jadwal, 'absensi' => $absensi]),
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
        let absensi = @json($absensi);
        $('#tanggal').val(absensi.tanggal);
        $('#keterangan').val(absensi.keterangan);
    </script>
@endpush
