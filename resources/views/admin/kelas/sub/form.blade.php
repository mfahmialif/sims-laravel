<div class="col-12">
    <div class="input-block local-forms">
        <label>Kelas <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('kelas_id') is-invalid @enderror" name="kelas_id" required>
            <option value="">Pilih Status</option>
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

@push('script')
    <script>
        const previewImg = document.getElementById("preview");
        const fileInfo = document.getElementById("file-info");
        const uploadLabel = document.getElementById("upload-label");

        const defaultPreview = ""; // atau set URL default preview gambar di sini jika ada

        function handleFileUpload(input) {
            const file = input.files[0];

            if (file) {
                const isImage = file.type.startsWith("image/");
                if (!isImage) {
                    previewImg.style.display = "none";
                    fileInfo.innerText = "Belum ada file";
                    uploadLabel.innerText = "Pilih File";
                    return;
                }

                previewImg.src = URL.createObjectURL(file);
                previewImg.style.display = "block";
                fileInfo.innerText = file.name;
                uploadLabel.innerText = "Ganti File";
            } else {
                previewImg.src = defaultPreview;
                previewImg.style.display = defaultPreview ? "block" : "none";
                fileInfo.innerText = "Belum ada file";
                uploadLabel.innerText = "Pilih File";
            }
        }
    </script>
@endpush
