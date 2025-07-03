<div class="col-12">
    <div class="input-block local-forms">
        <label>Nama<span class="login-danger">*</span></label>
        <input class="form-control @error('nama') is-invalid @enderror" name="nama" type="text" required
            placeholder="" value="{{ old('nama') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Kode<span class="login-danger">*</span></label>
        <input class="form-control @error('kode') is-invalid @enderror" name="kode" type="text" required
            placeholder="" value="{{ old('kode') }}">
        @error('kode')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-12">
    <div class="input-block local-forms">
        <label>Semester<span class="login-danger">*</span></label>
        <select class="form-control select2 @error('status') is-invalid @enderror" name="semester" required>
            <option value="">Pilih Semester</option>
            @foreach ($semester as $item)
                <option value="{{ $item }}">{{ $item }}</option>
            @endforeach
            
        </select>
        @error('semester')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-12">
    <div class="input-block local-forms">
        <label>Status<span class="login-danger">*</span></label>
        <select class="form-control select2 @error('status') is-invalid @enderror" name="status" required>
            <option value="">Pilih Status</option>
            <option value="aktif">Aktif</option>
            <option value="tidak aktif">Tidak Aktif</option>
        </select>
        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <button onclick="location.href = '{{ route('admin.tahun-pelajaran.index') }}'" type="button"
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
