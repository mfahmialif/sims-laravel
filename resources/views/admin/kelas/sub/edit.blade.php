@extends('layouts.admin.template')
@section('title', 'Edit Data Sub Kelas')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.sub.index', ['kelas' => $kelas]) }}">Sub Kelas </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Sub Kelas</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kelas.sub.update', ['kelasSub' => $kelasSub, 'kelas' => $kelas]) }}"
                        onsubmit="submitForm(this)" method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Sub Kelas</h4>
                                </div>
                            </div>
                            @include('admin.kelas.sub.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const kelasSub = @json($kelasSub);

        $('#form_edit').find('input[name="sub"]').val(kelasSub.sub);
        $('#form_edit').find('select[name="kelas_id"]').val(kelasSub.kelas_id).change();
        $('#form_edit').find('input[name="keterangan"]').val(kelasSub.keterangan);
    </script>
@endpush
