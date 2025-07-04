<div class="col-12">
    <div class="input-block local-forms">
        <label>Kelas <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('kelas_sub_id') is-invalid @enderror" id="kelas_sub_id" name="kelas_sub_id" required tabindex="1">
            <option value="">Pilih Kelas</option>
            @foreach ($kurikulumDetail->mataPelajaran->kelas->sub as $item)
                <option value="{{ $item->id }}" {{ old('kelas_sub_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->kelas->angka }} {{ $item->sub }}
                </option>
            @endforeach
        </select>
        @error('kelas_sub_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms input-group">
        <label>Pencarian Guru <span class="login-danger">*</span></label>
        <input class="form-control @error('nama') is-invalid @enderror" id="search" name="search" type="text"
            placeholder="" value="{{ old('search') }}" tabindex="2" onfocus="this.select()">
        <input type="hidden" name="guru_id" id="guru_id" value="{{ old('guru_id') }}">
        <button class="btn btn-danger" type="button" onclick="clearSearch()"><i class="fa fa-trash"></i></button>
        @error('search')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Nama <span class="login-danger">*</span></label>
        <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" type="text"
            placeholder="" readonly value="{{ old('nama') }}">
        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>NIP <span class="login-danger">*</span></label>
        <input class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" type="text"
            placeholder="" readonly value="{{ old('nip') }}">
        @error('nip')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>NIK <span class="login-danger">*</span></label>
        <input class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" type="text"
            placeholder="" readonly value="{{ old('nik') }}">
        @error('nik')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Jenis Kelamin <span class="login-danger">*</span></label>
        <input class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin"
            type="text" placeholder="" readonly value="{{ old('jenis_kelamin') }}">
        @error('jenis_kelamin')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Hari <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('hari') is-invalid @enderror" id="hari" name="hari" required tabindex="3">
            <option value="">Pilih Hari</option>
            @foreach (\Helper::getEnumValues('jadwal', 'hari') as $item)
                <option value="{{ $item }}" {{ old('hari') == $item ? 'selected' : '' }}>
                    {{ $item }}
                </option>
            @endforeach
        </select>
        @error('hari')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Jam Mulai <span class="login-danger">*</span></label>
        <input class="form-control @error('jam_mulai') is-invalid @enderror" id="jam_mulai" name="jam_mulai"
            type="time" placeholder="" value="{{ old('jam_mulai') }}" tabindex="4">
        @error('jam_mulai')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Jam Selesai <span class="login-danger">*</span></label>
        <input class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai" name="jam_selesai"
            type="time" placeholder="" value="{{ old('jam_selesai') }}" tabindex="5">
        @error('jam_selesai')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <button
            onclick="location.href = '{{ route('admin.jadwal.detail.index', ['kurikulumDetail' => $kurikulumDetail, 'tahunPelajaran' => $tahunPelajaran]) }}'"
            type="button" class="btn btn-primary cancel-form">Batalkan</button>
    </div>
</div>

@push('css')
    <style>
        input[readonly] {
            background-color: rgba(46, 55, 164, 0.1);
        }
    </style>
@endpush
@push('script')
    <script>
        $('#search').autocomplete({
            source: function(request, response) {
                var url = "{{ route('admin.kepala-sekolah.autocomplete', ['query' => 'query']) }}";
                url = url.replace('query', request.term);

                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        response(data.map(item => ({
                            label: item.label,
                            value: item.value,
                            data: item
                        })));
                    }
                });
            },
            select: function(event, ui) {
                $('#guru_id').val(ui.item.value);
                let data = ui.item.data.data;
                $('#nama').val(data.nama);
                $('#nip').val(data.nip);
                $('#nik').val(data.nik);
                $('#jenis_kelamin').val(data.jenis_kelamin);

                $('#search').val(ui.item.label);
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append(`<div style="padding: 5px; font-size: 14px;">${item.label}</div>`)
                .appendTo(ul);
        };

        function clearSearch() {
            $('#search').val('');
            $('#guru_id').val('');
            $('#nama').val('');
            $('#nip').val('');
            $('#nik').val('');
            $('#jenis_kelamin').val('');
            $('#search').focus();
        }
    </script>
@endpush
