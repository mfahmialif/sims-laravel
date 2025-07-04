@extends('layouts.admin.template')
@section('title', 'Jadwal')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Data Jadwal</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="col-12">
                <div class="input-block local-forms">
                    <select class="form-control select2 filter-dt" id="filter_tahun_pelajaran_id" required>
                        @foreach ($tahunPelajaran as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama }} {{ $item->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="kurikulum">

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>

        function loadKurikulum() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.jadwal.data') }}",
                data: {
                    tahun_pelajaran_id: $('#filter_tahun_pelajaran_id').val()
                },
                dataType: "html",
                success: function(response) {
                    $('#kurikulum').html(response);
                }
            });
        }

        $('#filter_tahun_pelajaran_id').change(function (e) {
            loadKurikulum();
        });

        loadKurikulum();
    </script>
@endpush
