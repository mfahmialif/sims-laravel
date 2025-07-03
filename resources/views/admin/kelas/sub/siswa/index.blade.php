@extends('layouts.admin.template')
@section('title', 'Siswa Kelas')
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
                    <strong>Kelas {{ $kelas->angka }} ({{ $kelas->romawi }}) - {{ $kelasSub->sub }}</strong>.
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
                                            <a href="{{ route('admin.kelas.sub.siswa.add', ['kelas' => $kelas, 'kelasSub' => $kelasSub]) }}"
                                                class="btn btn-primary add-pluss ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/plus.svg"
                                                    alt=""></a>
                                            <a href="javascript:void(0);" onclick="searchDataTable('#table1', true)"
                                                class="btn btn-primary doctor-refresh ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/re-fresh.svg"
                                                    alt=""></a>
                                            <a href="javascript:void(0);" onclick="deleteSiswa()"
                                                class="btn btn-primary doctor-refresh ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/trash.svg"
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
                                    <th style="width: 5%">
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" id="check-all" type="checkbox"
                                                value="something">
                                        </div>
                                    </th>
                                    <th style="width: 5%">No</th>
                                    <th>Kelas</th>
                                    <th>Sub Kelas</th>
                                    <th>Siswa</th>
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
        let selectedIds = new Set();

        var table1 = dataTable('#table1');
        $('#search-table').focus();

        var searchTimeout = null;

        $('.filter-dt').change(function(e) {
            e.preventDefault();
            table1.ajax.reload();
        });

        $('#check-all').on('change', function() {
            $('.check-table').prop('checked', this.checked);
            $('.check-table').each(function() {
                saveSelectedId(this);
            });
        });

        $(document).on('change', '.check-table', function() {
            $('#check-all').prop('checked', $('.check-table:checked').length === $('.check-table').length);
            saveSelectedId(this);
        });

        $('#table1').on('draw.dt', function() {
            $('.check-table').each(function() {
                if (selectedIds.has($(this).val())) {
                    $(this).prop('checked', true);
                }
            });
            $('#check-all').prop('checked', false);
        });

        function saveSelectedId(element) {
            let id = $(element).val();
            if (element.checked) {
                selectedIds.add(id);
            } else {
                selectedIds.delete(id);
            }
        }

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
            var url = "{{ route('admin.kelas.sub.siswa.data', ['kelas' => $kelas, 'kelasSub' => $kelasSub]) }}"
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
                            return `
                            <div class="form-check check-tables">
                                <input class="form-check-input check-table status_daftar_checkbox" type="checkbox" name="status_daftar_checkbox[]" value="${data}">
                            </div>
                            `;
                        },
                        className: "text-middle",
                        orderable: false,
                    }, {
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
                        "{{ route('admin.kelas.sub.siswa.destroy', ['kelas' => $kelas, 'kelasSub' => $kelasSub, 'kelasSiswa' => '_kelasSiswa']) }}";
                    url = url.replace('_kelasSiswa', id);
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

        function deleteSiswa() {

            let siswa_id = Array.from(selectedIds);

            if (siswa_id.length === 0) {
                swal('Peringatan!', 'Pilih setidaknya satu siswa terlebih dahulu.', 'warning');
                return;
            }

            swal({
                title: "Apa kamu yakin?",
                text: "Data yang akan dihapus tidak akan bisa dikembalikan",
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
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.kelas.sub.siswa.bulk-destroy', ['kelas' => $kelas, 'kelasSub' => $kelasSub]) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: siswa_id,
                        },
                        success: function(response) {
                            showToastr(response.status, response.message);
                            selectedIds.clear();
                            table1.ajax.reload();
                            $('#check-all').prop('checked', false);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseText);
                        },
                    });
                }
            });
        }
    </script>
@endpush
