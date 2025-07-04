<div class="col-12">
    <div class="input-block local-forms">
        <label>Nama <span class="login-danger">*</span></label>
        <input class="form-control @error('nama') is-invalid @enderror" name="nama" type="text" placeholder=""
            value="{{ old('nama') }}">
        @error('nama')
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
