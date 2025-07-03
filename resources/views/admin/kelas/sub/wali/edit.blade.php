@extends('layouts.admin.template')
@section('title', 'Edit Data Wali Kelas')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.sub.index', ['kelas' => $kelas]) }}">Sub Kelas
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active"><a
                            href="{{ route('admin.kelas.sub.wali.index', ['kelas' => $kelas, 'kelasSub' => $kelasSub]) }}">Wali
                            Kelas
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Data Wali Kelas</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ route('admin.kelas.sub.wali.update', ['kelas' => $kelas, 'kelasSub' => $kelasSub, 'kelasWali' => $kelasWali]) }}"
                        onsubmit="submitForm(this)" method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Sub Kelas</h4>
                                </div>
                            </div>
                            @include('admin.kelas.sub.wali.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const kelasWali = @json($kelasWali);
        console.log(kelasWali);
        $('#guru_id').val(kelasWali.guru_id);
        $('#nama').val(kelasWali.guru.nama);
        $('#nip').val(kelasWali.guru.nip);
        $('#nik').val(kelasWali.guru.nik);
        $('#jenis_kelamin').val(kelasWali.guru.jenis_kelamin);
        $('#search').val(kelasWali.guru.nama + ' (' + kelasWali.guru.nip + ')');
    </script>
@endpush
