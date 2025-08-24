@extends('layouts.admin.template')
@section('title', 'Input Nilai')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.nilai.index') }}">Nilai </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Input Nilai</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="alert alert-info d-flex align-items-center gap-2" role="alert">
                <i class="feather-info"></i>
                <div>
                    <strong>Informasi:</strong> Anda sedang menginput nilai untuk <br>
                    Kelas <strong>{{ $jadwal->kelasSub->kelas->angka }} {{ $jadwal->kelasSub->sub }}</strong>.<br>
                    Mata Pelajaran <strong>{{ $jadwal->kurikulumDetail->mataPelajaran->nama }}</strong>.<br>
                    Guru <strong>{{ $jadwal->guru->nama }}</strong>.<br>
                    Jadwal <strong>{{ $jadwal->hari }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})</strong>.<br>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.nilai.input.store', ['jadwal' => $jadwal]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Input Nilai</h4>
                                </div>
                            </div>
                            @include('admin.nilai.input.form', [
                                'url' => route('admin.nilai.input.data-form', ['jadwal' => $jadwal]),
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
