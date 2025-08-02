@push('css')
    <style>
        .input-nilai {
            width: 50px !important;
        }

        /* Chrome, Safari, Edge, Opera */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

<div class="card card-table show-entire">
    <div class="card-body">

        <!-- /Table Header -->
        <div class="table-responsive">
            <table id="table1" class="table border-0 custom-table comman-table datatable mb-0 table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Siswa</th>

                        @foreach ($kelompokKomponen as $jenis => $komponenList)
                            <th class="text-center" colspan="{{ count($komponenList) }}">
                                {{ ucfirst($jenis) }}
                            </th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($kelompokKomponen as $jenis => $komponenList)
                            @foreach ($komponenList as $komponen)
                                <th class="text-center">
                                    {!! implode('<br>', explode(' ', $komponen['nama'])) !!}
                                </th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-12 pb-4">
    <div class="doctor-submit text-end">
        <button type="submit" id="btn-submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>

{{-- <ul id="list_siswa" class="d-none"> --}}
<ul id="list_siswa">

</ul>
@push('script')
    <script>
        let kelompokKomponen = @json($kelompokKomponen);

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
                paginate: false,
                search: false,
                ajax: {
                    url: url,
                    data: function(d) {
                        // d.kelas_id = jadwal.id;
                    },
                },
                lengthMenu: [
                    [5, 10, 20, 50, 100, -1],
                    [5, 10, 20, 50, 100, 'All']
                ],
                deferRender: true,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        className: "text-middle",
                        orderable: false,
                    },
                    ...Object.entries(kelompokKomponen).flatMap(([jenis, komponenList]) =>
                        komponenList.map(komponen => ({
                            data: `nilai.${komponen.id}`,
                            name: `nilai.${komponen.id}`,
                            className: 'text-center',
                            render: (data, type, row) => {
                                console.log(row);
                                const inputType = jenis === 'sikap' ? 'text' : 'number';
                                const disabled = komponen.nama === 'Nilai' ? 'disabled' : '';
                                const nilaiDetail = row.nilai_detail.find(item => item
                                    .komponen_nilai_id === komponen.id);
                                if (komponen.id) { // nilai detail atau nilai per komponen
                                    const nilaiValue = typeof nilaiDetail === 'undefined' ? 0 : nilaiDetail.nilai;

                                    return `<input type="${inputType}" class="form-control form-control-sm text-center input-nilai nilai_${row.id}_${jenis}"
                    name="nilai[${row.id}][${komponen.id}]" value="${nilaiValue}" ${disabled} onchange="hitungNilai(${row.id}, '${jenis}', ${komponen.bobot})"  oninput="hitungNilai(${row.id}, '${jenis}', ${komponen.bobot})"/>`;
                                } else { // nilai akhir per jenis
                                    const nilai = row.nilai.find(item => item
                                        .jenis === jenis);
                                    const nilaiValue = typeof nilai === 'undefined' ? 0 : nilai.nilai_akhir;
                                    return `<input type="${inputType}" class="form-control form-control-sm text-center input-nilai"
    id="nilai_${row.id}_${jenis}" name="nilai[${row.id}][${jenis}]" value="${nilaiValue}" ${disabled} />`;

                                }
                            },
                            orderable: false
                        }))
                    )
                ]
            })
            return datatable;
        }

        function hitungNilai(siswaId, jenis, bobot) {
            if (jenis === 'sikap') {
                return;
            }

            const nilai = $('.nilai_' + siswaId + '_' + jenis);
            let totalNilai = 0;
            nilai.each(function() {
                totalNilai += parseFloat($(this).val());
            })
            const nilaiAkhir = (totalNilai * bobot) / 100;
            $(`#nilai_${siswaId}_${jenis}`).val(nilaiAkhir.toFixed(2));
        }

        function submitFormThis() {
            $('#btn-submit').attr('disabled', true);
            $('#btn-submit').html('Processing...');
        }
    </script>
@endpush
