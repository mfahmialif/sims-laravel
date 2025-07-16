<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-heading">
                    <h4>Absensi</h4>
                </div>
            </div>
            <div class="col-12">
                <div class="input-block local-forms">
                    <label>Tanggal <span class="login-danger">*</span></label>
                    <input class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" type="date"
                        value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="input-block local-forms">
                    <label>Keterangan</label>
                    <textarea class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan"
                        cols="30" rows="3"></textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
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
                        <th style="width: 5%">No</th>
                        <th>Nama</th>
                        <th style="width: 5%">
                            <div class="form-check check-tables text-center">
                                <input class="form-check-input" name="check-all-status" id="check-all-hadir"
                                    type="radio" value="hadir">
                                <label class="form-check-label d-block small" for="check-all-hadir">Hadir</label>
                            </div>
                        </th>
                        <th style="width: 5%">
                            <div class="form-check check-tables text-center">
                                <input class="form-check-input" name="check-all-status" id="check-all-sakit"
                                    type="radio" value="sakit">
                                <label class="form-check-label d-block small" for="check-all-sakit">Sakit</label>
                            </div>
                        </th>
                        <th style="width: 5%">
                            <div class="form-check check-tables text-center">
                                <input class="form-check-input" name="check-all-status" id="check-all-izin"
                                    type="radio" value="izin">
                                <label class="form-check-label d-block small" for="check-all-izin">Izin</label>
                            </div>
                        </th>
                        <th style="width: 5%">
                            <div class="form-check check-tables text-center">
                                <input class="form-check-input" name="check-all-status" id="check-all-alpha"
                                    type="radio" value="alpha">
                                <label class="form-check-label d-block small" for="check-all-alpha">Alpha</label>
                            </div>
                        </th>
                    </tr>

                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<ul id="list_siswa" class="d-none"></ul>

<div class="col-12 pb-4">
    <div class="doctor-submit text-end">
        <button type="submit" id="btn-submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.absensi.rekap.index', ['jadwal' => $jadwal]) }}"
            class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>
@push('script')
    <script>
        let jadwal = @json($jadwal);
        let selectedIds = new Map();

        var table1 = dataTable('#table1');
        $('#search-table').focus();

        var searchTimeout = null;

        $('.filter-dt').change(function(e) {
            e.preventDefault();
            table1.ajax.reload();
        });

        $('#table1').on('draw.dt', function() {
            for (let [key, val] of selectedIds) {
                console.log(key, val);
                $(`input[type=radio][name="status[${key}]"][value="${val}"]`).prop('checked', true);
            }
            $('input[name="check-all-status"]').prop('checked', false);
        });

        initCheck();

        function initCheck() {

            const status = ['hadir', 'sakit', 'izin', 'alpha'];

            status.forEach(value => {
                value = '-' + value;
                $('#check-all' + value).on('change', function() {
                    $('.check-table' + value).prop('checked', this.checked);
                    $('.check-table' + value).each(function() {
                        saveSelectedId(this);
                    });
                });

                $(document).on('change', '.check-table' + value, function() {
                    $('#check-all' + value).prop('checked', $(`.check-table${value}:checked`).length === $(
                        '.check-table' + value).length);
                    saveSelectedId(this);
                });
            });

        }

        function saveSelectedId(element) {
            let value = $(element).val();
            let inputName = $(element).attr('name');
            let key = parseInt(inputName.match(/\[(.*?)\]/)?.[1]);
            let name = `data[${key}]`;

            if (element.checked) {
                selectedIds.set(key, value);
                $('#list_siswa').append(`
                    <li id="list_siswa_${key}"><input type="text" name="${name}" value="${value}"></li>
                `);
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
            var url = "{{ $url }}"
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
                        // d.kelas_id = jadwal.id;
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
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        className: "text-middle"
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            console.log(row);
                            return `
                                <div class="form-check check-tables">
                                    <input class="form-check-input check-table-hadir"
                                        type="radio"
                                        name="status[${data}]"
                                        value="hadir"
                                        data-id="${data}"
                                        ${row.absensi_detail_status === 'hadir' ? 'checked' : ''}
                                    >
                                </div>
                            `;
                        },
                        className: "text-middle",
                        orderable: false,
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="form-check check-tables">
                                    <input class="form-check-input check-table-sakit"
                                        type="radio"
                                        name="status[${data}]"
                                        value="sakit"
                                        data-id="${data}"
                                        ${row.absensi_detail_status === 'sakit' ? 'checked' : ''}
                                    >
                                </div>
                            `;
                        },
                        className: "text-middle",
                        orderable: false,
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="form-check check-tables">
                                    <input class="form-check-input check-table-izin"
                                        type="radio"
                                        name="status[${data}]"
                                        value="izin"
                                        data-id="${data}"
                                        ${row.absensi_detail_status === 'izin' ? 'checked' : ''}
                                    >
                                </div>
                            `;
                        },
                        className: "text-middle",
                        orderable: false,
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="form-check check-tables">
                                    <input class="form-check-input check-table-alpha"
                                        type="radio"
                                        name="status[${data}]"
                                        value="alpha"
                                        data-id="${data}"
                                        ${row.absensi_detail_status === 'alpha' ? 'checked' : ''}
                                    >
                                </div>
                            `;
                        },
                        className: "text-middle",
                        orderable: false,
                    },
                ]
            })
            return datatable;
        }

        function submitFormThis() {
            $('#btn-submit').attr('disabled', true);
            $('#btn-submit').html('Processing...');
        }
    </script>
@endpush
