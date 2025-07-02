@extends('layouts.admin.template')
@section('title', 'Edit Data User')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Kelas</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kelas.update', ['kelas' => $kelas]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Kelas</h4>
                                </div>
                            </div>
                            @include('admin.kelas.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const kelas = @json($kelas);
        $('#form_edit').find('select[name="romawi"]').val(kelas.romawi).trigger('change');
        $('#form_edit').find('select[name="angka"]').val(kelas.angka).trigger('change');
        $('#form_edit').find('textarea[name="keterangan"]').val(kelas.keterangan);
    </script>
@endpush
