<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-heading">
                    <h4>Kurikulum</h4>
                </div>
            </div>
            <div class="col-12">
                <div class="input-block local-forms">
                    <label>Nama Kurikulum <span class="login-danger">*</span></label>
                    <input class="form-control @error('nama') is-invalid @enderror" name="nama" type="text"
                        value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="input-block local-forms">
                    <label>Tahun Pelajaran <span class="login-danger">*</span></label>
                    <select class="form-control select2 filter-dt" id="tahun_pelajaran_id" name="tahun_pelajaran_id"
                        required>
                        <option value="">Pilih Tahun Pelajaran</option>
                        @foreach ($tahunPelajaran as $item)
                            <option value="{{ $item->id }}"
                                {{ old('tahun_pelajaran_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }} {{ $item->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="page-table-header mb-2">
            <div class="row align-items-center">
                <div class="col">
                    <div class="doctor-table-blk">
                        <h3>Mata Pelajaran</h3>
                    </div>
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
                                <input class="form-check-input" id="check-all" type="checkbox" value="something">
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
                                    <input class="form-check-input check-table status_daftar_checkbox" type="checkbox"
                                        name="mata_pelajaran_id[]" value="{{ $item->id }}">
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

<div class="col-12 pb-4">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.kurikulum.index') }}" class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>

@push('script')
    <script>
        //  var table1 = dataTable('#tableAdd');
        $('#check-all').on('change', function() {
            $('.check-table').not(':disabled').prop('checked', this.checked);
        });

        $(document).on('change', '.check-table', function() {
            $('#check-all').prop('checked', $('.check-table:checked').length === $('.check-table').length);
        });

        var datatable = $("#tableAdd").DataTable({
            dom: "<'d-flex justify-content-end align-items-center m-3'f>rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>",
            columnDefs: [{
                    targets: 0,
                    orderable: false
                } // kolom ke-0 tidak bisa diurutkan
            ],
            paging: false,
            info: false
        });
    </script>
@endpush
