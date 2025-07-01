@extends('layouts.admin.template')
@section('title', 'Edit Data Tahun Pelajaran')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.tahun-pelajaran.index') }}">Tahun Pelajaran</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Tahun Pelajaran</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.tahun-pelajaran.update', ['tahunPelajaran' => $tahunPelajaran]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Tahun Pelajaran</h4>
                                </div>
                            </div>
                            @include('admin.tahun-pelajaran.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const tahunPelajaran = @json($tahunPelajaran);
        $('#form_edit').find('select[name="semester"]').val(tahunPelajaran.semester).trigger('change');
        $('#form_edit').find('input[name="kode"]').val(tahunPelajaran.kode);
        $('#form_edit').find('input[name="nama"]').val(tahunPelajaran.nama);
        $('#form_edit').find('select[name="status"]').val(tahunPelajaran.status).trigger('change');
    </script>
@endpush
