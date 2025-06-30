<div class="col-12">
    <div class="input-block local-forms">
        <label>Name <span class="login-danger">*</span></label>
        <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" required
            placeholder="" value="{{ old('name') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Jenis Kelamin <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
            <option value="">Pilih Jenis Kelamin</option>
            @foreach ($jenisKelamin as $item)
                <option value="{{ $item }}" {{ old('jenis_kelamin') == $item ? 'selected' : '' }}>
                    {{ $item }}
                </option>
            @endforeach
        </select>
        @error('jenis_kelamin')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Role <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('role_id') is-invalid @enderror" name="role_id" required>
            <option value="">Pilih Role User</option>
            @foreach ($role as $item)
                <option value="{{ $item->id }}" {{ old('role_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>
        @error('role_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Username <span class="login-danger">*</span></label>
        <input class="form-control @error('username') is-invalid @enderror" name="username" type="text" required
            placeholder="" value="{{ old('username') }}">
        @error('username')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Password <span class="login-danger">*</span></label>
        <input class="form-control pass-input @error('password') is-invalid @enderror" type="password" name="password"
            required>
        <span class="profile-views feather-eye-off toggle-password"></span>
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Confirm Password <span class="login-danger">*</span></label>
        <input class="form-control pass-input-confirm" type="password" name="password_confirmation" required>
        <span class="profile-views feather-eye-off confirm-password"></span>
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Email</label>
        <input class="form-control @error('email') is-invalid @enderror" name="email" type="text" placeholder=""
            value="{{ old('email') }}">
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <img id="preview" src="" class="mb-4 avatar-preview" alt="Preview"
        style="display: none; max-height: 150px;" />

    <div class="input-block local-top-form">
        <label class="local-top">
            Avatar
        </label>

        <div class="settings-btn upload-files-avator">
            <input type="file" name="avatar" id="avatar" accept="image/*"
                class="hide-input @error('avatar') is-invalid @enderror" onchange="handleFileUpload(this)" />

            <label for="avatar" id="file-info" class="file-info-text">Belum ada file</label>
            <label for="avatar" class="upload" id="upload-label">Pilih File</label>
        </div>
        @error('avatar')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <button onclick="location.href = '{{ route('admin.user.index') }}'" type="button"
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
