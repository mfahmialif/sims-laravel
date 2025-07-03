<div class="card card-table show-entire">
    <div class="card-body">
        <!-- Table Header -->
        <div class="page-table-header mb-2">
            <div class="row align-items-center">
                <div class="col">
                    <div class="doctor-table-blk">
                        <h3>Centang Siswa</h3>
                        <div class="doctor-search-blk mt-3 mt-md-0">
                            <div class="top-nav-search table-search-blk">
                                <form onsubmit="event.preventDefault(); searchDataTable('#table1');">
                                    <input type="text" class="form-control" id="search-table"
                                        oninput="searchDataTable('#table1')" placeholder="Search here">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end float-end ms-auto download-grp">
                    <div class="add-group">
                        <a href="javascript:void(0);" onclick="searchDataTable('#table1', true)"
                            class="btn btn-primary doctor-refresh ms-2"><img
                                src="{{ asset('template') }}/assets/img/icons/re-fresh.svg" alt=""></a>
                    </div>
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
                                <input class="form-check-input" id="check-all" type="checkbox" value="something">
                            </div>
                        </th>
                        <th style="width: 5%">No</th>
                        <th>Tahun</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
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

<ul id="list_siswa" class="d-none">

</ul>

<div class="col-12 pb-4">
    <div class="doctor-submit text-end">
        <button type="submit" id="btn-submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.kelas.sub.siswa.index', ['kelas' => $kelas, 'kelasSub' => $kelasSub]) }}"
            class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>
@push('script')
    <script>
        let kelas = @json($kelas);
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
                $('#list_siswa').append(`
                    <li id="list_siswa_${id}"><input type="text" name="siswa_id[]" value="${id}"></li>
                `);
            } else {
                selectedIds.delete(id);
                $('#list_siswa_' + id).remove();
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
            var url = "{{ route('admin.kelas.sub.siswa.data-siswa', ['kelas' => $kelas, 'kelasSub' => $kelasSub]) }}"
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
                        d.kelas_id = kelas.id;
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
                                <input class="form-check-input check-table status_daftar_checkbox" type="checkbox" value="${data}">
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
                        data: 'kelas_angka',
                        name: 'kelas_angka',
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

        function submitFormThis() {
            $('#btn-submit').attr('disabled', true);
            $('#btn-submit').html('Processing...');
        }
    </script>
@endpush
