@extends('layouts.admin.template')
@section('title', 'Tambah Data Kurikulum')
@section('content')
<p>
    {{ $mataPelajaran }}
</p>
    <form action="{{ Route('admin.kurikulum.store') }}" method="post">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.kurikulum.index') }}">Kurikulum</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Tambah Kurikulum</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <form action="{{ route('admin.kurikulum.store') }}" onsubmit="submitForm(this)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Tambah Data Kurikulum</h4>
                                </div>
                            </div>
                            @include('admin.kurikulum.form')
                        </div>
                    </form> --}}
                        <div class="page-table-header mb-2">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="doctor-table-blk">
                                        <h3>Data List Pelajaran</h3>
                                        <div class="doctor-search-blk mt-3 mt-md-0">
                                            <div class="top-nav-search table-search-blk">
                                                <form onsubmit="event.preventDefault(); searchDataTable('#tableAdd');">
                                                    <input type="text" class="form-control" id="search-table"
                                                        oninput="searchDataTable('#tableAdd')" placeholder="Search here">
                                                    <a class="btn"><img
                                                            src="{{ asset('template') }}/assets/img/icons/search-normal.svg"
                                                            alt=""></a>
                                                </form>
                                            </div>
                                            <div class="add-group">
                                                {{-- <a href="{{ route('admin.kurikulum.add') }}"
                                                class="btn btn-primary add-pluss ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/plus.svg"
                                                    alt=""></a>
                                            <a href="javascript:void(0);" onclick="searchDataTable('#tableAdd', true)"
                                                class="btn btn-primary doctor-refresh ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/re-fresh.svg"
                                                    alt=""></a>
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ asset('template') }}/assets/img/icons/bar-icon.svg"
                                                        alt="">
                                                </button> --}}
                                                {{-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach ($status as $item)
                                                        <li><button class="dropdown-item"
                                                                onclick="changeStatusDaftar('{{ $item }}')">Ganti
                                                                status:
                                                                <b>{{ strtoupper($item) }}</b></button></li>
                                                    @endforeach
                                                </ul> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <a href="javascript:;" class=" me-2"><img
                                        src="{{ asset('template') }}/assets/img/icons/pdf-icon-01.svg" alt=""></a>
                                <a href="javascript:;" class=" me-2"><img
                                        src="{{ asset('template') }}/assets/img/icons/pdf-icon-02.svg" alt=""></a>
                                <a href="javascript:;" class=" me-2"><img
                                        src="{{ asset('template') }}/assets/img/icons/pdf-icon-03.svg" alt=""></a>
                                <a href="javascript:;"><img src="{{ asset('template') }}/assets/img/icons/pdf-icon-04.svg"
                                        alt=""></a>
                            </div>
                        </div>
                    </div>
                    <!-- /Table Header -->
                    <div class="table-responsive">
                        <table id="tableAdd" class="table border-0 custom-table comman-table datatable mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%">
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" id="check-all" type="checkbox"
                                                value="something">
                                        </div>
                                    </th>
                                    <th style="width: 5%">No</th>
                                    <th>Kode</th>
                                    <th>Mata Pelajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mataPelajaran as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input check-table status_daftar_checkbox"
                                                    type="checkbox" name="pelajaran_id[]" value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $item->iteration }}</td>
                                        <td>
                                            {{ $item->kode }}
                                        </td>
                                        <td>
                                            {{ $item->nama }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection
@push('script')
    <script>
        //  var table1 = dataTable('#tableAdd');
        var datatable = $("#tableAdd").DataTable();
        // $('#search-table').focus();
        //  function dataTable(tableId) {
        //     var url = "{{ route('admin.siswa.data') }}"

        //     var datatable = $(tableId).DataTable({
        //         // responsive: true,
        //         dom: "rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>",
        //         autoWidth: false,
        //         processing: true,
        //         serverSide: true,
        //         order: [
        //             [1, "desc"]
        //         ],
        //         search: {
        //             return: true,
        //         },
        //         ajax: {
        //             url: url,
        //             data: function(d) {
        //                 d.tahun_pelajaran_id = $('#filter_tahun_pelajaran_id').val();
        //                 d.jenis_kelamin = $('#filter_jenis_kelamin').val();
        //                 // d.search = $('#search-table').val();
        //             },
        //         },
        //         deferRender: true,
        //         columns: [{
        //                 data: 'id',
        //                 render: function(data, type, row, meta) {
        //                     return `
    //                     <div class="form-check check-tables">
    //                         <input class="form-check-input check-table status_daftar_checkbox" type="checkbox" name="status_daftar_checkbox[]" value="${data}">
    //                     </div>
    //                     `;
        //                 },
        //                 className: "text-middle",
        //                 orderable: false,
        //             },
        //             {
        //                 data: 'id',
        //                 render: function(data, type, row, meta) {
        //                     return meta.row + meta.settings._iDisplayStart + 1;
        //                 },
        //             },
        //             {
        //                 data: 'tahun_pelajaran_kode',
        //                 name: 'tahun_pelajaran_kode',
        //                 className: "text-middle"
        //             },
        //             {
        //                 data: 'nama_siswa',
        //                 name: 'nama_siswa',
        //                 className: "text-middle"
        //             },
        //             {
        //                 data: 'jenis_kelamin',
        //                 name: 'jenis_kelamin',
        //                 className: "text-middle"
        //             },
        //             {
        //                 data: 'status',
        //                 name: 'status',
        //                 className: "text-middle"
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 className: "text-end",
        //                 searchable: false,
        //                 orderable: false
        //             },
        //         ],
        //     })
        //     return datatable;
        // }
    </script>
@endpush
