@extends('layouts.admin.template')
@section('title', 'Edit Guru')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.guru.index') }}">Guru</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Guru</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.guru.update', ['guru' => $guru]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Guru</h4>
                                </div>
                            </div>
                            @include('admin.guru.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function setFormEdit(data, form) {
            Object.entries(data).forEach(([key, value]) => {
                if (value === null) return; // Lewati jika nilainya null

                const element = form.find(`[name="${key}"]`);

                const assetUrl = {
                    'foto': "{{ asset('foto_guru') }}",
                    'sk_spns': "{{ asset('sk_spns') }}",
                    'sk_pengangkatan': "{{ asset('sk_pengangkatan') }}",
                }
                if (element.length > 0) {
                    // Logika untuk mengisi berbagai jenis input
                    if (element.is('select') && element.hasClass('select2-hidden-accessible')) {
                        element.val(value).trigger('change'); // Set value dan update Select2
                    } else if (element.is('[type="file"]')) {
                        $('#file-info-' + key).text(value);
                        $('.view-' + key).removeClass('d-none');
                        $('#view-' + key).attr('href', assetUrl[key] + '/' + value);
                    } else if (element.is(':radio')) {
                        form.find(`[name="${key}"][value="${value}"]`).prop('checked', true);
                    } else if (element.is(':checkbox')) {
                        if (Array.isArray(value)) {
                            element.each(function() {
                                $(this).prop('checked', value.includes($(this).val()));
                            });
                        } else {
                            element.prop('checked', !!value);
                        }
                    } else {
                        element.val(value); // Untuk input teks, textarea, select biasa
                    }
                }
            });
        }

        $(document).ready(function() {
            const guru = @json($guru);
            const oldData = @json(session()->getOldInput());
            const hasOldData = Object.keys(oldData).length > 0;

            function getValue(key) {
                // Prioritas 1: Ambil dari old data jika ada
                if (hasOldData && oldData[key] !== undefined) {
                    return oldData[key];
                }

                // Prioritas 2: Ambil dari data guru, mendukung nested object (cth: 'user.email')
                if (key.includes('.')) {
                    const keys = key.split('.');
                    let value = guru;
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
                return guru[key] !== undefined ? guru[key] : '';
            }

            const form = $('#form_edit');

            form.find('.input-edit').removeClass('d-none');
            form.find('.input-edit').find('input, select, textarea').prop('required', true);
            form.find('.input-password').find('input').prop('required', false);

            setFormEdit(guru, form);
            form.find('input[name="username"]').val(guru.user.username);
            form.find('input[name="email"]').val(getValue('user.email'));




            // if (!hasOldData && guru.foto) {
            //     $('#file-info').text(guru.foto);
            //     $('.view-foto').removeClass('d-none');
            //     $('#view-foto').attr('href', "{{ asset('foto_guru') }}" + '/' + guru.foto);
            // }

            // if (!hasOldData && guru.akta_lahir_path) {
            //     $('#file-info-akta').text(guru.akta_lahir_path);
            //     $('.view-akta').removeClass('d-none');
            //     $('#view-akta').attr('href', "{{ asset('akta_lahir_path') }}" + '/' + guru.akta_lahir_path);
            // }
        });
    </script>
@endpush
