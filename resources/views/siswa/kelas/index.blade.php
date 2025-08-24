@extends('layouts.admin.template')
@section('title', 'Siswa Kelas')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Kelas </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Data Siswa Kelas</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info d-flex align-items-center gap-2" role="alert">
                <i class="feather-info"></i>
                <div>
                    <strong>Informasi:</strong> Anda sedang melihat data siswa untuk
                    <strong>Kelas {{ $kelasSub->kelas->angka }} ({{ $kelasSub->kelas->romawi }}) -
                        {{ $kelasSub->sub }}</strong>.
                </div>
            </div>
            <div class="card card-table show-entire">
                <div class="card-body">

                    <!-- Table Header -->
                    <div class="page-table-header mb-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="doctor-table-blk">
                                    <h3>Data Siswa Kelas</h3>
                                    <div class="doctor-search-blk mt-3 mt-md-0">
                                        <div class="top-nav-search table-search-blk">
                                            <form onsubmit="event.preventDefault(); searchDataTable('#table1');">
                                                <input type="text" class="form-control" id="search-table"
                                                    oninput="searchDataTable('#table1')" placeholder="Search here">
                                                <a class="btn"><img
                                                        src="{{ asset('template') }}/assets/img/icons/search-normal.svg"
                                                        alt=""></a>
                                            </form>
                                        </div>
                                        <div class="add-group">
                                            <a href="javascript:void(0);" onclick="searchDataTable('#table1', true)"
                                                class="btn btn-primary doctor-refresh ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/re-fresh.svg"
                                                    alt=""></a>
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
                        <table id="table1" class="table border-0 custom-table comman-table datatable mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Kelas</th>
                                    <th>Sub Kelas</th>
                                    <th>Siswa</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        let selectedIds = new Set();

        var table1 = dataTable('#table1');
        $('#search-table').focus();

        var searchTimeout = null;

        $('.filter-dt').change(function(e) {
            e.preventDefault();
            table1.ajax.reload();
        });


        function searchDataTable(tableId, refresh = false) {
            var time = refresh ? 0 : 700;

            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(function() {
                $(tableId).DataTable().search(
                    $('#search-table').val()
                ).draw();
            }, time);
        }

        function dataTable(tableId) {
            var url = "{{ route('siswa.kelas.data', ['kelasSub' => $kelasSub]) }}"
            var datatable = $(tableId).DataTable({
                // responsive: true,
                dom: "rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>",
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [1, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                    data: function(d) {
                        // d.search = $('#search-table').val();
                    },
                },
                lengthMenu: [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, 'All']
                ],
                deferRender: true,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'kelas_angka',
                        name: 'kelas_angka',
                        className: "text-middle"
                    },
                    {
                        data: 'sub',
                        name: 'sub',
                        className: "text-middle"
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        className: "text-middle"
                    },
                ],
            })
            return datatable;
        }
    </script>
@endpush
