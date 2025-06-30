{{-- DATA AKUN & TAHUN AJARAN --}}
<div class="col-12">
    <h5 class="form-title"><span>Data Akun & Akademik</span></h5>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Tahun Pelajaran <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('tahun_pelajaran_id') is-invalid @enderror" name="tahun_pelajaran_id"
            required>
            <option value="">Pilih Tahun Pelajaran</option>
            @foreach ($tahunPelajaran as $item)
                <option value="{{ $item->id }}" {{ old('tahun_pelajaran_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama }} {{ $item->semester }} {{-- Sesuaikan nama kolom --}}
                </option>
            @endforeach
        </select>
        @error('tahun_pelajaran_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 status_daftar d-none">
    <div class="input-block local-forms">
        <label>Status Daftar <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('status_daftar') is-invalid @enderror" name="status_daftar">
            <option value="">Pilih Status Daftar</option>
            @foreach ($statusDaftar as $item)
                <option value="{{ $item }}" {{ old('status_daftar') == $item ? 'selected' : '' }}>
                    {{ $item }} {{-- Sesuaikan nama kolom --}}
                </option>
            @endforeach
        </select>
        @error('tahun_pelajaran_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Email</label>
        <input class="form-control @error('email') is-invalid @enderror" name="email" type="text"
            value="{{ old('email') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr>

{{-- INFORMASI PRIBADI SISWA --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Informasi Pribadi Siswa</span></h5>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Nama Lengkap Siswa <span class="login-danger">*</span></label>
        <input class="form-control @error('nama_siswa') is-invalid @enderror" name="nama_siswa" type="text"
            value="{{ old('nama_siswa') }}" required>
        @error('nama_siswa')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Jenis Kelamin <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
            <option value="">Pilih Jenis Kelamin</option>
            @foreach (['Laki-Laki', 'Perempuan'] as $item)
                <option value="{{ $item }}" {{ old('jenis_kelamin') == $item ? 'selected' : '' }}>
                    {{ $item }}</option>
            @endforeach
        </select>
        @error('jenis_kelamin')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIS</label>
        <input class="form-control @error('nis') is-invalid @enderror" name="nis" type="text"
            value="{{ old('nis') }}">
        @error('nis')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NISN</label>
        <input class="form-control @error('nisn') is-invalid @enderror" name="nisn" type="text"
            value="{{ old('nisn') }}">
        @error('nisn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Tempat Lahir <span class="login-danger">*</span></label>
        <input class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" type="text"
            value="{{ old('tempat_lahir') }}" required>
        @error('tempat_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Tanggal Lahir <span class="login-danger">*</span></label>
        <input class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" type="date"
            value="{{ old('tanggal_lahir') }}" required>
        @error('tanggal_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Agama <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('agama') is-invalid @enderror" name="agama" required>
            <option value="">Pilih Agama</option>
            @foreach ($agama as $item)
                <option value="{{ $item }}" {{ old('agama', 'Islam') == $item ? 'selected' : '' }}>
                    {{ $item }}</option>
            @endforeach
        </select>
        @error('agama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIK Anak</label>
        <input class="form-control @error('nik_anak') is-invalid @enderror" name="nik_anak" type="text"
            value="{{ old('nik_anak') }}">
        @error('nik_anak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>KK</label>
        <input class="form-control @error('kk') is-invalid @enderror" name="kk" type="text"
            value="{{ old('kk') }}">
        @error('kk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>No Registrasi Akta Lahir</label>
        <input class="form-control @error('no_registrasi_akta_lahir') is-invalid @enderror"
            name="no_registrasi_akta_lahir" type="text" value="{{ old('no_registrasi_akta_lahir') }}">
        @error('no_registrasi_akta_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Anak Ke-</label>
        <input class="form-control @error('anak_ke') is-invalid @enderror" name="anak_ke" type="number"
            value="{{ old('anak_ke') }}">
        @error('anak_ke')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Jumlah Saudara Kandung</label>
        <input class="form-control @error('jumlah_saudara_kandung') is-invalid @enderror"
            name="jumlah_saudara_kandung" type="number" value="{{ old('jumlah_saudara_kandung') }}">
        @error('jumlah_saudara_kandung')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Masuk Sekolah Sebagai</label>
        <input class="form-control @error('masuk_sekolah_sebagai') is-invalid @enderror" name="masuk_sekolah_sebagai"
            type="text" value="{{ old('masuk_sekolah_sebagai') }}">
        @error('masuk_sekolah_sebagai')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Asal Sekolah/TK</label>
        <input class="form-control @error('asal_sekolah_tk') is-invalid @enderror" name="asal_sekolah_tk"
            type="text" value="{{ old('asal_sekolah_tk') }}">
        @error('asal_sekolah_tk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<hr>

{{-- INFORMASI FISIK & LAINNYA --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Informasi Fisik & Lainnya</span></h5>
</div>
<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Tinggi Badan (cm)</label>
        <input class="form-control @error('tinggi_badan') is-invalid @enderror" name="tinggi_badan" type="number"
            value="{{ old('tinggi_badan') }}">
        @error('tinggi_badan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Berat Badan (kg)</label>
        <input class="form-control @error('berat_badan') is-invalid @enderror" name="berat_badan" type="number"
            value="{{ old('berat_badan') }}">
        @error('berat_badan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Lingkar Kepala (cm)</label>
        <input class="form-control @error('lingkar_kepala') is-invalid @enderror" name="lingkar_kepala"
            type="number" value="{{ old('lingkar_kepala') }}">
        @error('lingkar_kepala')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Golongan Darah</label>
        <input class="form-control @error('gol_darah') is-invalid @enderror" name="gol_darah" type="text"
            value="{{ old('gol_darah') }}">
        @error('gol_darah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Tinggal Bersama</label>
        <input class="form-control @error('tinggal_bersama') is-invalid @enderror" name="tinggal_bersama"
            type="text" value="{{ old('tinggal_bersama') }}" placeholder="Orang Tua / Wali / Lainnya">
        @error('tinggal_bersama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Transportasi ke Sekolah</label>
        <input class="form-control @error('transportasi_ke_sekolah') is-invalid @enderror"
            name="transportasi_ke_sekolah" type="text" value="{{ old('transportasi_ke_sekolah') }}">
        @error('transportasi_ke_sekolah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<hr>

{{-- ALAMAT SISWA --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Alamat Siswa (Sesuai Kartu Keluarga)</span></h5>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Alamat Lengkap <span class="login-danger">*</span></label>
        <textarea class="form-control @error('alamat_anak_sesuai_kk') is-invalid @enderror" name="alamat_anak_sesuai_kk"
            rows="3" required>{{ old('alamat_anak_sesuai_kk') }}</textarea>
        @error('alamat_anak_sesuai_kk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>RT</label>
        <input class="form-control @error('rt_anak') is-invalid @enderror" name="rt_anak" type="text"
            value="{{ old('rt_anak') }}">
        @error('rt_anak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>RW</label>
        <input class="form-control @error('rw_anak') is-invalid @enderror" name="rw_anak" type="text"
            value="{{ old('rw_anak') }}">
        @error('rw_anak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>Desa / Kelurahan <span class="login-danger">*</span></label>
        <input class="form-control @error('desa_kelurahan_anak') is-invalid @enderror" name="desa_kelurahan_anak"
            type="text" value="{{ old('desa_kelurahan_anak') }}" required>
        @error('desa_kelurahan_anak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>Kecamatan <span class="login-danger">*</span></label>
        <input class="form-control @error('kecamatan_anak') is-invalid @enderror" name="kecamatan_anak"
            type="text" value="{{ old('kecamatan_anak') }}" required>
        @error('kecamatan_anak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>Kabupaten / Kota <span class="login-danger">*</span></label>
        <input class="form-control @error('kabupaten_anak') is-invalid @enderror" name="kabupaten_anak"
            type="text" value="{{ old('kabupaten_anak') }}" required>
        @error('kabupaten_anak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>Kode Pos</label>
        <input class="form-control @error('kode_pos_anak') is-invalid @enderror" name="kode_pos_anak" type="text"
            value="{{ old('kode_pos_anak') }}">
        @error('kode_pos_anak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr>
{{-- DATA ORANG TUA --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Data Orang Tua</span></h5>
</div>
{{-- AYAH --}}
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Nama Ayah</label>
        <input class="form-control @error('nama_ayah') is-invalid @enderror" name="nama_ayah" type="text"
            value="{{ old('nama_ayah') }}">
        @error('nama_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIK Ayah</label>
        <input class="form-control @error('nik_ayah') is-invalid @enderror" name="nik_ayah" type="text"
            value="{{ old('nik_ayah') }}">
        @error('nik_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pendidikan Terakhir Ayah</label>
        <input class="form-control @error('pendidikan_ayah') is-invalid @enderror" name="pendidikan_ayah"
            type="text" value="{{ old('pendidikan_ayah') }}">
        @error('pendidikan_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pekerjaan Ayah</label>
        <input class="form-control @error('pekerjaan_ayah') is-invalid @enderror" name="pekerjaan_ayah"
            type="text" value="{{ old('pekerjaan_ayah') }}">
        @error('pekerjaan_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- IBU --}}
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Nama Ibu Kandung</label>
        <input class="form-control @error('nama_ibu_sesuai_ktp') is-invalid @enderror" name="nama_ibu_sesuai_ktp"
            type="text" value="{{ old('nama_ibu_sesuai_ktp') }}">
        @error('nama_ibu_sesuai_ktp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIK Ibu</label>
        <input class="form-control @error('nik_ibu') is-invalid @enderror" name="nik_ibu" type="text"
            value="{{ old('nik_ibu') }}">
        @error('nik_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pendidikan Terakhir Ibu</label>
        <input class="form-control @error('pendidikan_ibu') is-invalid @enderror" name="pendidikan_ibu"
            type="text" value="{{ old('pendidikan_ibu') }}">
        @error('pendidikan_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pekerjaan Ibu</label>
        <input class="form-control @error('pekerjaan_ibu') is-invalid @enderror" name="pekerjaan_ibu" type="text"
            value="{{ old('pekerjaan_ibu') }}">
        @error('pekerjaan_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
{{-- KONTAK ORTU --}}
<div class="col-12">
    <div class="input-block local-forms">
        <label>No. Telepon Orang Tua</label>
        <input class="form-control @error('nomor_telepon_orang_tua') is-invalid @enderror"
            name="nomor_telepon_orang_tua" type="text" value="{{ old('nomor_telepon_orang_tua') }}">
        @error('nomor_telepon_orang_tua')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<hr>

{{-- DATA WALI --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Data Wali (Isi jika berbeda dengan Orang Tua)</span></h5>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Nama Wali</label>
        <input class="form-control @error('nama_wali') is-invalid @enderror" name="nama_wali" type="text"
            value="{{ old('nama_wali') }}">
        @error('nama_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIK Wali</label>
        <input class="form-control @error('nik_wali') is-invalid @enderror" name="nik_wali" type="text"
            value="{{ old('nik_wali') }}">
        @error('nik_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pendidikan Wali</label>
        <input class="form-control @error('pendidikan_wali') is-invalid @enderror" name="pendidikan_wali"
            type="text" value="{{ old('pendidikan_wali') }}">
        @error('pendidikan_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pekerjaan Wali</label>
        <input class="form-control @error('pekerjaan_wali') is-invalid @enderror" name="pekerjaan_wali"
            type="text" value="{{ old('pekerjaan_wali') }}">
        @error('pekerjaan_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Alamat Wali</label>
        <textarea class="form-control @error('alamat_wali') is-invalid @enderror" name="alamat_wali" rows="3">{{ old('alamat_wali') }}</textarea>
        @error('alamat_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>No. Telepon Wali</label>
        <input class="form-control @error('nomor_telepon_wali') is-invalid @enderror" name="nomor_telepon_wali"
            type="text" value="{{ old('nomor_telepon_wali') }}">
        @error('nomor_telepon_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<hr>

{{-- UPLOAD FILE --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Upload Berkas</span></h5>
</div>
<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">
            Foto
        </label>

        <div class="settings-btn upload-files-avator">
            <input type="file" name="foto" id="foto" accept="image/*"
                class="hide-input @error('foto') is-invalid @enderror"
                onchange="handleFileUpload(this, 'file-info', 'upload-label')" />

            <label for="foto" id="file-info" class="file-info-text">Belum ada file</label>
            <label for="foto" class="upload" id="upload-label">Pilih File</label>
        </div>
        @error('avatar')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <div class="ms-2 mb-4 view-foto d-none">
            <small class="text-decoration-underline"><a href="" id="view-foto">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">
            Akta Kelahiran
        </label>

        <div class="settings-btn upload-files-avator">
            <input type="file" name="akta_lahir_path" id="akta_lahir_path" accept="image/*"
                class="hide-input @error('akta_lahir_path') is-invalid @enderror"
                onchange="handleFileUpload(this, 'file-info-akta', 'upload-label-akta')" />

            <label for="akta_lahir_path" id="file-info-akta" class="file-info-text">Belum ada file</label>
            <label for="akta_lahir_path" class="upload" id="upload-label-akta">Pilih File</label>
        </div>
        @error('akta_lahir_path')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <div class="ms-2 mb-4 view-akta d-none">
            <small class="text-decoration-underline"><a href="" id="view-akta">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>

    </div>
</div>

{{-- TOMBOL SUBMIT --}}
<div class="col-12 mt-5">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.pendaftaran-siswa-baru.index') }}"
            class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>

@push('script')
    <script>
        const defaultPreview = ""; // atau set URL default preview gambar di sini jika ada

        function handleFileUpload(input, fileInfoId, uploadLabelId) {
            const fileInfo = document.getElementById(fileInfoId);
            const uploadLabel = document.getElementById(uploadLabelId);
            const file = input.files[0];

            if (file) {
                const isImage = file.type.startsWith("image/");
                if (!isImage) {
                    fileInfo.innerText = "Belum ada file";
                    uploadLabel.innerText = "Pilih File";
                    return;
                }

                fileInfo.innerText = file.name;
                uploadLabel.innerText = "Ganti File";
            } else {
                fileInfo.innerText = "Belum ada file";
                uploadLabel.innerText = "Pilih File";
            }
        }
    </script>
@endpush
@push('css')
    <style>
        .form-title {
            margin-bottom: 24px;
        }
    </style>
@endpush
