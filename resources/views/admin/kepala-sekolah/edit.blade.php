@extends('layouts.admin.template')
@section('title', 'Edit Kepala Sekolah')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kepala-sekolah.index') }}">Kepala Sekolah </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Kepala Sekolah</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kepala-sekolah.update', ['kepalaSekolah' => $kepalaSekolah]) }}"
                        onsubmit="submitForm(this)" method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Kepala Sekolah</h4>
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
@push('script')
    <script>
        const kepalaSekolah = @json($kepalaSekolah);
        const oldData = @json(session()->getOldInput());
        const hasOldData = Object.keys(oldData).length > 0;

        function getValue(key) {
            // Prioritas 1: Ambil dari old data jika ada
            if (hasOldData && oldData[key] !== undefined) {
                return oldData[key];
            }

            // Prioritas 2: Ambil dari data kepalaSekolah, mendukung nested object (cth: 'user.email')
            if (key.includes('.')) {
                const keys = key.split('.');
                let value = kepalaSekolah;
                for (const k of keys) {
                    if (value && typeof value === 'object' && k in value) {
                        value = value[k];
                    } else {
                        return ''; // Kembalikan string kosong jika path tidak valid
                    }
                }
                return value;
            }

            // Ambil dari properti langsung di objek guru
            return kepalaSekolah[key] !== undefined ? kepalaSekolah[key] : '';
        }

        console.log(getValue('guru.nama'));

        $('#guru_id').val(getValue('guru_id'));
        $('#nama').val(getValue('guru.nama'));
        $('#nip').val(getValue('guru.nip'));
        $('#nik').val(getValue('guru.nik'));
        $('#jenis_kelamin').val(getValue('guru.jenis_kelamin'));
        $('#mulai_menjabat').val(getValue('mulai_menjabat'));
        $('#selesai_menjabat').val(getValue('selesai_menjabat'));

        let search = getValue('search') != '' ?
            getValue('search') :
            getValue('guru.nama') + ' (' + getValue('guru.nip') + ')';
        $('#search').val(search);
    </script>
@endpush
