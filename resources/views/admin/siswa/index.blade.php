@extends('layouts.admin.template')
@section('title', 'Siswa')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Siswa </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Data Siswa</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">

            <div class="alert alert-info" role="alert">
                Siswa hanya bisa ditambahkan dari <b>data pendaftaran siswa baru</b> dengan status <b>DITERIMA</b>.<br>
                Jika klik tambah <b><i class="feather-plus"></i></b> maka akan diarahkan ke halaman <b>pendaftaran siswa
                    baru</b>.
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="input-block local-forms">
                        <select class="form-control select2 filter-dt" id="filter_tahun_pelajaran_id" required>
                            <option value="">Semua Tahun Pelajaran</option>
                            @foreach ($tahunPelajaran as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama }} {{ $item->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="input-block local-forms">
                        <select class="form-control select2 filter-dt" id="filter_jenis_kelamin" required>
                            <option value="">Semua Jenis Kelamin</option>
                            @foreach ($jenisKelamin as $item)
                                <option value="{{ $item }}">
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card card-table show-entire">
                <div class="card-body">
                    <!-- Table Header -->
                    <div class="page-table-header mb-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="doctor-table-blk">
                                    <h3>Data Siswa</h3>
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
                                            <a href="{{ route('admin.pendaftaran-siswa-baru.add') }}"
                                                class="btn btn-primary add-pluss ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/plus.svg"
                                                    alt=""></a>
                                            <a href="javascript:void(0);" onclick="searchDataTable('#table1', true)"
                                                class="btn btn-primary doctor-refresh ms-2"><img
                                                    src="{{ asset('template') }}/assets/img/icons/re-fresh.svg"
                                                    alt=""></a>
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ asset('template') }}/assets/img/icons/bar-icon.svg"
                                                        alt="">
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach ($status as $item)
                                                        <li><button class="dropdown-item"
                                                                onclick="changeStatusDaftar('{{ $item }}')">Ganti
                                                                status:
                                                                <b>{{ strtoupper($item) }}</b></button></li>
                                                    @endforeach
                                                </ul>
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
                                    <th>Tahun</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
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

        $('.filter-dt').change(function(e) {
            e.preventDefault();
            table1.ajax.reload();
        });

        $('#check-all').on('change', function() {
            $('.check-table').prop('checked', this.checked);
        });

        $(document).on('change', '.check-table', function() {
            $('#check-all').prop('checked', $('.check-table:checked').length === $('.check-table').length);
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
            var url = "{{ route('admin.siswa.data') }}"
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
                    return: false,
                },
                ajax: {
                    url: url,
                    data: function(d) {
                        d.tahun_pelajaran_id = $('#filter_tahun_pelajaran_id').val();
                        d.jenis_kelamin = $('#filter_jenis_kelamin').val();
                        // d.search = $('#search-table').val();
                    },
                },
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
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'tahun_pelajaran_kode',
                        name: 'tahun_pelajaran_kode',
                        className: "text-middle"
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        className: "text-middle"
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        className: "text-middle"
                    },
                    {
                        data: 'status',
                        name: 'status',
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
                    var url = "{{ route('admin.siswa.destroy', ['siswa' => '_siswa']) }}";
                    url = url.replace('_siswa', id);
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

        function changeStatusDaftar(status) {

            let siswa_id = [];
            // Ambil semua checkbox yang diceklis
            $('.status_daftar_checkbox:checked').each(function() {
                siswa_id.push($(this).val());
            });

            if (siswa_id.length === 0) {
                swal('Peringatan!', 'Pilih setidaknya satu siswa terlebih dahulu.', 'warning');
                return;
            }

            $.ajax({
                type: "PUT",
                url: "{{ route('admin.siswa.update-status') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    siswa_id: siswa_id,
                    status: status
                },
                success: function(response) {
                    showToastr(response.status, response.message);
                    table1.ajax.reload();
                },
                error: function(xhr) {
                    toastr.error(xhr.responseText);
                },
                complete: function() {
                    $('#check-all').prop('checked', false);
                }
            });
        }
    </script>
@endpush
