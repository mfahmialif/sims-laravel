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
        <button onclick="location.href = '{{ route('admin.kelas.sub.index', ['kelas' => $kelas]) }}'" type="button"
            class="btn btn-primary cancel-form">Batalkan</button>
    </div>
</div>
