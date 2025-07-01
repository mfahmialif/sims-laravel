@extends('layouts.admin.template')
@section('title', 'Edit Data Kurikulum')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kurikulum.index') }}">Kurikulum</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Kurikulum</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kurikulum.update', ['kurikulum' => $kurikulum]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Kurikulum</h4>
                                </div>
                            </div>
                            @include('admin.kurikulum.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const kurikulum = @json($kurikulum);
        $('#form_edit').find('select[name="tahun"]').val(kurikulum.tahun_pelajaran_id).trigger('change');
        $('#form_edit').find('select[name="pelajaran"]').val(kurikulum.mata_pelajaran_id).trigger('change');
    </script>
@endpush
