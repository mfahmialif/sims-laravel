<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Romawi</label>
        <input class="form-control @error('romawi') is-invalid @enderror" name="romawi" type="text"
            value="{{ old('romawi') }}">
        @error('romawi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Angka</label>
        <input class="form-control @error('angka') is-invalid @enderror" name="angka" type="number"
            value="{{ old('angka') }}">
        @error('angka')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Keterangan</label>
        <textarea class="form-control  @error('keterangan') is-invalid @enderror"  name="keterangan" id="keterangan" cols="30" rows="10"></textarea>
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
        <button onclick="location.href = '{{ route('admin.kelas.index') }}'" type="button"
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
