<div class="col-12">
    <div class="input-block local-forms">
        <label>Kelas <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('kelas_id') is-invalid @enderror" name="kelas_id" required>
            <option value="">Pilih Kelas</option>
            @foreach ($dataKelas as $item)
                <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->angka }}</option>
            @endforeach
        </select>
        @error('kelas_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-forms">
        <label>Sub <span class="login-danger">*</span></label>
        <input class="form-control @error('sub') is-invalid @enderror" name="sub" type="text" placeholder=""
            value="{{ old('sub') }}">
        @error('sub')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-forms">
        <label>Keterangan</label>
        <textarea class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan"
            cols="30" rows="10">{{ old('keterangan') }}</textarea>
        @error('keterangan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <button onclick="location.href = '{{ route('admin.role.index') }}'" type="button"
            class="btn btn-primary cancel-form">Batalkan</button>
    </div>
</div>
