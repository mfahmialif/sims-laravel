{{-- DATA PRIBADI & IDENTITAS --}}
<div class="col-12">
    <h5 class="form-title"><span>Data Pribadi & Identitas</span></h5>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Nama Lengkap <span class="login-danger">*</span></label>
        <input class="form-control @error('nama') is-invalid @enderror" name="nama" type="text"
            value="{{ old('nama') }}" required>
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>NIP <span class="login-danger">*</span></label>
        <input class="form-control @error('nip') is-invalid @enderror" name="nip" type="text"
            value="{{ old('nip') }}" required>
        @error('nip')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>NIK <span class="login-danger">*</span></label>
        <input class="form-control @error('nik') is-invalid @enderror" name="nik" type="text"
            value="{{ old('nik') }}" required>
        @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>No. KK</label>
        <input class="form-control @error('no_kk') is-invalid @enderror" name="no_kk" type="text"
            value="{{ old('no_kk') }}">
        @error('no_kk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>NUPTK</label>
        <input class="form-control @error('nuptk') is-invalid @enderror" name="nuptk" type="text"
            value="{{ old('nuptk') }}">
        @error('nuptk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>NPWP</label>
        <input class="form-control @error('npwp') is-invalid @enderror" name="npwp" type="text"
            value="{{ old('npwp') }}">
        @error('npwp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Jenis Kelamin <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
            <option value="">Pilih Jenis Kelamin</option>
            <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Agama <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('agama') is-invalid @enderror" name="agama" required>
            <option value="">Pilih Agama</option>
            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
            <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
        </select>
        @error('agama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Tempat Lahir <span class="login-danger">*</span></label>
        <input class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" type="text"
            value="{{ old('tempat_lahir') }}" required>
        @error('tempat_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Tanggal Lahir <span class="login-danger">*</span></label>
        <input class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" type="date"
            value="{{ old('tanggal_lahir') }}" required>
        @error('tanggal_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Kewarganegaraan</label>
        <input class="form-control @error('kewarganegaraan') is-invalid @enderror" name="kewarganegaraan"
            type="text" value="{{ old('kewarganegaraan', 'Indonesia') }}">
        @error('kewarganegaraan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr>

{{-- DATA KEPEGAWAIAN --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Data Kepegawaian</span></h5>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Status Kepegawaian <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('status_kepegawaian') is-invalid @enderror"
            name="status_kepegawaian" required>
            <option value="">Pilih Status</option>
            <option value="PNS" {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
            <option value="PPPK" {{ old('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
            <option value="GTY" {{ old('status_kepegawaian') == 'GTY' ? 'selected' : '' }}>GTY</option>
            <option value="GTT" {{ old('status_kepegawaian') == 'GTT' ? 'selected' : '' }}>GTT</option>
            <option value="Honorer" {{ old('status_kepegawaian') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
        </select>
        @error('status_kepegawaian')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Jenis PTK <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('jenis_ptk') is-invalid @enderror" name="jenis_ptk" required>
            <option value="">Pilih Jenis PTK</option>
            <option value="Kepala Sekolah" {{ old('jenis_ptk') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah
            </option>
            <option value="Wakil Kepala Sekolah" {{ old('jenis_ptk') == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>
                Wakil Kepala Sekolah</option>
            <option value="Guru Kelas" {{ old('jenis_ptk') == 'Guru Kelas' ? 'selected' : '' }}>Guru Kelas</option>
            <option value="Guru Mata Pelajaran" {{ old('jenis_ptk') == 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru
                Mata Pelajaran</option>
            <option value="Guru Bimbingan Konseling"
                {{ old('jenis_ptk') == 'Guru Bimbingan Konseling' ? 'selected' : '' }}>Guru Bimbingan Konseling
            </option>
            <option value="Guru TIK" {{ old('jenis_ptk') == 'Guru TIK' ? 'selected' : '' }}>Guru TIK</option>
            <option value="Guru Pendamping Khusus"
                {{ old('jenis_ptk') == 'Guru Pendamping Khusus' ? 'selected' : '' }}>Guru Pendamping Khusus</option>
            <option value="Tenaga Administrasi Sekolah"
                {{ old('jenis_ptk') == 'Tenaga Administrasi Sekolah' ? 'selected' : '' }}>Tenaga Administrasi Sekolah
            </option>
            <option value="Pustakawan" {{ old('jenis_ptk') == 'Pustakawan' ? 'selected' : '' }}>Pustakawan</option>
            <option value="Laboran" {{ old('jenis_ptk') == 'Laboran' ? 'selected' : '' }}>Laboran</option>
            <option value="Teknisi" {{ old('jenis_ptk') == 'Teknisi' ? 'selected' : '' }}>Teknisi</option>
            <option value="Penjaga Sekolah" {{ old('jenis_ptk') == 'Penjaga Sekolah' ? 'selected' : '' }}>Penjaga
                Sekolah</option>
            <option value="Lainnya" {{ old('jenis_ptk') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
        @error('jenis_ptk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>No. SK CPNS</label>
        <input class="form-control @error('no_sk_cpns') is-invalid @enderror" name="no_sk_cpns" type="text"
            value="{{ old('no_sk_cpns') }}">
        @error('no_sk_cpns')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Tanggal CPNS</label>
        <input class="form-control @error('tanggal_cpns') is-invalid @enderror" name="tanggal_cpns" type="date"
            value="{{ old('tanggal_cpns') }}">
        @error('tanggal_cpns')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">SK CPNS</label>
        <div class="settings-btn upload-files-avator">
            <input type="file" name="sk_cpns" id="sk_cpns"
                class="hide-input @error('sk_cpns') is-invalid @enderror" accept=".pdf"
                onchange="handleFileUpload(this, 'file-info-sk_cpns', 'upload-label-sk_cpns')" />
            <label for="sk_cpns" id="file-info-sk_cpns" class="file-info-text">Belum ada file</label>
            <label for="sk_cpns" class="upload" id="upload-label-sk_cpns">Pilih File</label>
        </div>
        @error('sk_cpns')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div class="ms-2 mb-4 view-sk_cpns d-none">
            <small class="text-decoration-underline"><a href="" id="view-sk_cpns">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>
    </div>
</div>


<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>No. SK Pengangkatan <span class="login-danger">*</span></label>
        <input class="form-control @error('no_sk_pengangkatan') is-invalid @enderror" name="no_sk_pengangkatan"
            type="text" value="{{ old('no_sk_pengangkatan') }}" required>
        @error('no_sk_pengangkatan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>TMT Pengangkatan <span class="login-danger">*</span></label>
        <input class="form-control @error('tmt_pengangkatan') is-invalid @enderror" name="tmt_pengangkatan"
            type="date" value="{{ old('tmt_pengangkatan') }}" required>
        @error('tmt_pengangkatan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">SK Pengangkatan</label>
        <div class="settings-btn upload-files-avator">
            <input type="file" name="sk_pengangkatan" id="sk_pengangkatan"
                class="hide-input @error('sk_pengangkatan') is-invalid @enderror" accept=".pdf"
                onchange="handleFileUpload(this, 'file-info-sk_pengangkatan', 'upload-label-sk_pengangkatan')" />
            <label for="sk_pengangkatan" id="file-info-sk_pengangkatan" class="file-info-text">Belum ada file</label>
            <label for="sk_pengangkatan" class="upload" id="upload-label-sk_pengangkatan">Pilih File</label>
        </div>
        @error('sk_pengangkatan')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div class="ms-2 mb-4 view-sk_pengangkatan d-none">
            <small class="text-decoration-underline"><a href="" id="view-sk_pengangkatan">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Lembaga Pengangkatan <span class="login-danger">*</span></label>
        <input class="form-control @error('lembaga_pengangkatan') is-invalid @enderror" name="lembaga_pengangkatan"
            type="text" value="{{ old('lembaga_pengangkatan') }}" required>
        @error('lembaga_pengangkatan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Pangkat/Golongan</label>
        <input class="form-control @error('pangkat_golongan') is-invalid @enderror" name="pangkat_golongan"
            type="text" value="{{ old('pangkat_golongan') }}">
        @error('pangkat_golongan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Tugas Tambahan</label>
        <input class="form-control @error('tugas_tambahan') is-invalid @enderror" name="tugas_tambahan"
            type="text" value="{{ old('tugas_tambahan') }}">
        @error('tugas_tambahan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr>

{{-- ALAMAT LENGKAP --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Alamat Lengkap</span></h5>
</div>

<div class="col-12">
    <div class="input-block local-forms">
        <label>Alamat Jalan <span class="login-danger">*</span></label>
        <textarea class="form-control @error('alamat_jalan') is-invalid @enderror" name="alamat_jalan" rows="3"
            required>{{ old('alamat_jalan') }}</textarea>
        @error('alamat_jalan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>RT</label>
        <input class="form-control @error('rt') is-invalid @enderror" name="rt" type="text"
            value="{{ old('rt') }}">
        @error('rt')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>RW</label>
        <input class="form-control @error('rw') is-invalid @enderror" name="rw" type="text"
            value="{{ old('rw') }}">
        @error('rw')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Nama Dusun</label>
        <input class="form-control @error('nama_dusun') is-invalid @enderror" name="nama_dusun" type="text"
            value="{{ old('nama_dusun') }}">
        @error('nama_dusun')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Desa/Kelurahan <span class="login-danger">*</span></label>
        <input class="form-control @error('desa_kelurahan') is-invalid @enderror" name="desa_kelurahan"
            type="text" value="{{ old('desa_kelurahan') }}" required>
        @error('desa_kelurahan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Kecamatan <span class="login-danger">*</span></label>
        <input class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" type="text"
            value="{{ old('kecamatan') }}" required>
        @error('kecamatan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Kabupaten <span class="login-danger">*</span></label>
        <input class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" type="text"
            value="{{ old('kabupaten') }}" required>
        @error('kabupaten')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Provinsi <span class="login-danger">*</span></label>
        <input class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" type="text"
            value="{{ old('provinsi') }}" required>
        @error('provinsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Kode Pos</label>
        <input class="form-control @error('kodepos') is-invalid @enderror" name="kodepos" type="text"
            value="{{ old('kodepos') }}">
        @error('kodepos')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>


<hr>

{{-- DATA AKUN & KONTAK --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Data Akun & Kontak</span></h5>
</div>


<div class="col-12 input-edit d-none">
    <div class="input-block local-forms">
        <label>Username <span class="login-danger">*</span></label>
        <input class="form-control @error('username') is-invalid @enderror" name="username" type="text"
            value="{{ old('username') }}">
        @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6 input-edit input-password d-none">
    <div class="input-block local-forms">
        <label>Password</label>
        <input class="form-control pass-input @error('password') is-invalid @enderror" type="password"
            name="password">
        <span class="profile-views feather-eye-off toggle-password"></span>
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6 input-edit input-password d-none">
    <div class="input-block local-forms">
        <label>Confirm Password</label>
        <input class="form-control pass-input-confirm" type="password" name="password_confirmation">
        <span class="profile-views feather-eye-off confirm-password"></span>
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Email</label>
        <input class="form-control @error('email') is-invalid @enderror" name="email" type="text"
            placeholder="" value="{{ old('email') }}">
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>No. HP</label>
        <input class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" type="text"
            value="{{ old('no_hp') }}">
        @error('no_hp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Status Akun</label>
        <select class="form-control select2 @error('status') is-invalid @enderror" name="status">
            <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">Foto</label>
        <div class="settings-btn upload-files-avator">
            <input type="file" name="foto" id="foto"
                class="hide-input @error('foto') is-invalid @enderror" accept=".jpg, .jpeg, .png"
                onchange="handleFileUpload(this, 'file-info-foto', 'upload-label')" />
            <label for="foto" id="file-info-foto" class="file-info-text">Belum ada file</label>
            <label for="foto" class="upload" id="upload-label">Pilih File</label>
        </div>
        @error('foto')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div class="ms-2 mb-4 view-foto d-none">
            <small class="text-decoration-underline"><a href="" id="view-foto">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>
    </div>
</div>

{{-- TOMBOL SUBMIT --}}
<div class="col-12 mt-5">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.guru.index') }}"
            class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>


@push('script')
    <script>
        function handleFileUpload(input, fileInfoId, uploadLabelId) {
            const fileInfo = document.getElementById(fileInfoId);
            const uploadLabel = document.getElementById(uploadLabelId);
            const file = input.files[0];

            if (file) {
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
            margin-top: 1rem;
        }

        hr {
            margin-top: 1.5rem;
            margin-bottom: 0;
        }
    </style>
@endpush
