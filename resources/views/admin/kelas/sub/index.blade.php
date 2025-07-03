@extends('layouts.admin.template')
@section('title', 'Sub Kelas')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Data Sub Kelas</li>
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
                    <strong>Kelas {{ $kelas->angka }} ({{ $kelas->romawi }})</strong>.
                </div>
            </div>

            <div class="card card-table show-entire">
                <div class="card-body">

                    <!-- Table Header -->
                    <div class="page-table-header mb-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="doctor-table-blk">
                                    <h3>Data Sub Kelas</h3>
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
                                            <a href="{{ route('admin.kelas.sub.add', ['kelas' => $kelas]) }}"
                                                class="btn btn-primary add-pluss ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/plus.svg"
                                                    alt=""></a>
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
                                    <th>Keterangan</th>
                                    <th>Action</th>
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
        var table1 = dataTable('#table1');
        $('#search-table').focus();

        var searchTimeout = null;

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
            var url = "{{ route('admin.kelas.sub.data', ['kelas' => $kelas]) }}"
            var datatable = $(tableId).DataTable({
                // responsive: true,
                dom: "rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>",
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
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
                        data: 'keterangan',
                        name: 'keterangan',
                        className: "text-middle"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-end",
                        searchable: false,
                        orderable: false
                    },
                ],
            })
            return datatable;
        }

        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var nama = event.target.querySelector('input[name="nama"]').value;
            swal({
                title: "Apa kamu yakin?",
                text: "Data yang akan dihapus: " + nama + ". Data tidak dapat dikembalikan!",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "OK",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: true
                    },
                    cancel: "Batalkan",
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var url =
                        "{{ route('admin.kelas.sub.destroy', ['kelasSub' => '_kelasSub', 'kelas' => $kelas]) }}";
                    url = url.replace('_kelasSub', id);
                    var fd = new FormData($(event.target)[0]);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            toastr.info('Loading...');
                        },
                        success: function(response) {
                            searchDataTable('#table1', true);
                            showToastr(response.status, response.message);
                        }
                    });
                }
            });
        }
    </script>
@endpush
