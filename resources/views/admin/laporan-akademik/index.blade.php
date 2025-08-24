@extends('layouts.admin.template')
@section('title', ' Laporan Akademik')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.laporan-akademik.index') }}">Laporan Akademik </a>
                    </li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Akademik</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jadwal Pelajaran</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan-akademik.laporanJadwal') }}" method="GET" target="_blank">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    <select class="form-control select2 filter-dt" id="filter_tahun_pelajaran_id_jadwal" name="tahun_pelajaran_id"
                                    >
                                        <option value="">Semua Tahun Pelajaran</option>
                                        @foreach ($tahunPelajaran as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama }} {{ $item->semester }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    <select class="form-control select2 filter-dt" id="filter_kelas_id_jadwal" name="kelas_id">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->angka }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-block local-forms">
                                    <select class="form-control select2 filter-dt" id="filter_kelas_sub_id_jadwal" name="kelas_sub_id">
                                        <option value="">Pilih Kelas Dulu</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <button type="submit" class="btn btn-danger w-100" id="btn-pdf-jadwal" value="pdf" name="submit">Download PDF</button>
                            </div>
                            <div class="col-12 col-md-6">
                                <button type="submit" class="btn btn-success w-100" id="btn-excel-jadwal" value="excel" name="submit">Download Excel</button>
                            </div>
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
        $('#filter_kelas_id_jadwal').change(function(e) {
            let kelas_id = $(this).val();
            let html = '';
            html += `<option value="">Semua Sub Kelas</option>`;
            kelasSub.forEach(element => {
                if (element.kelas_id == kelas_id) {
                    html += `<option value="${element.id}">${element.sub}</option>`;
                }
            });
            $('#filter_kelas_sub_id_jadwal').html(html);
        });
    </script>
@endpush
