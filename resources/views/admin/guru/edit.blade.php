@extends('layouts.admin.template')
@section('title', 'Edit Pendataran Siswa Baru')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.pendaftaran-siswa-baru.index') }}">Pendaftaran Siswa
                            Baru </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Pendaftaran Siswa Baru</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.pendaftaran-siswa-baru.update', ['siswa' => $siswa]) }}"
                        onsubmit="submitForm(this)" method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Pendataran Siswa Baru</h4>
                                </div>
                            </div>
                            @include('admin.pendaftaran-siswa-baru.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // Pastikan jQuery sudah dimuat sebelum skrip ini dijalankan
        $(document).ready(function() {
            // Ambil data siswa dan data 'old' dari Blade
            const siswa = @json($siswa);
            const oldData = @json(session()->getOldInput());
            const hasOldData = Object.keys(oldData).length > 0;

            // Fungsi helper untuk mendapatkan nilai, dengan prioritas pada old data
            function getValue(key) {
                // Prioritas 1: Ambil dari old data jika ada
                if (hasOldData && oldData[key] !== undefined) {
                    return oldData[key];
                }

                // Prioritas 2: Ambil dari data siswa, mendukung nested object (cth: 'user.email')
                if (key.includes('.')) {
                    const keys = key.split('.');
                    let value = siswa;
                    for (const k of keys) {
                        if (value && typeof value === 'object' && k in value) {
                            value = value[k];
                        } else {
                            return ''; // Kembalikan string kosong jika path tidak valid
                        }
                    }
                    return value;
                }

                // Ambil dari properti langsung di objek siswa
                return siswa[key] !== undefined ? siswa[key] : '';
            }

            // Cache selector form untuk efisiensi
            const form = $('#form_edit');

            // -------------------------------------------------------------------
            // MENGISI DATA UMUM (INPUT TEXT, DATE, NUMBER)
            // -------------------------------------------------------------------
            form.find('input[name="email"]').val(getValue('user.email'));
            form.find('.status_daftar').removeClass('d-none');
            form.find('.status_daftar').attr('required', true);


            // Informasi Siswa
            form.find('input[name="nis"]').val(getValue('nis'));
            form.find('input[name="nisn"]').val(getValue('nisn'));
            form.find('input[name="nama_siswa"]').val(getValue('nama_siswa'));
            form.find('input[name="tempat_lahir"]').val(getValue('tempat_lahir'));
            form.find('input[name="tanggal_lahir"]').val(getValue('tanggal_lahir'));
            form.find('input[name="nik_anak"]').val(getValue('nik_anak'));
            form.find('input[name="kk"]').val(getValue('kk'));
            form.find('input[name="no_registrasi_akta_lahir"]').val(getValue('no_registrasi_akta_lahir'));
            form.find('input[name="anak_ke"]').val(getValue('anak_ke'));
            form.find('input[name="jumlah_saudara_kandung"]').val(getValue('jumlah_saudara_kandung'));
            form.find('input[name="masuk_sekolah_sebagai"]').val(getValue('masuk_sekolah_sebagai'));
            form.find('input[name="asal_sekolah_tk"]').val(getValue('asal_sekolah_tk'));
            form.find('input[name="tinggi_badan"]').val(getValue('tinggi_badan'));
            form.find('input[name="berat_badan"]').val(getValue('berat_badan'));
            form.find('input[name="lingkar_kepala"]').val(getValue('lingkar_kepala'));
            form.find('input[name="jarak_tempuh_ke_sekolah"]').val(getValue('jarak_tempuh_ke_sekolah'));
            form.find('input[name="gol_darah"]').val(getValue('gol_darah'));

            // Alamat Siswa
            form.find('textarea[name="alamat_anak_sesuai_kk"]').val(getValue('alamat_anak_sesuai_kk'));
            form.find('input[name="desa_kelurahan_anak"]').val(getValue('desa_kelurahan_anak'));
            form.find('input[name="kecamatan_anak"]').val(getValue('kecamatan_anak'));
            form.find('input[name="kabupaten_anak"]').val(getValue('kabupaten_anak'));
            form.find('input[name="kode_pos_anak"]').val(getValue('kode_pos_anak'));
            form.find('input[name="rt_anak"]').val(getValue('rt_anak'));
            form.find('input[name="rw_anak"]').val(getValue('rw_anak'));
            form.find('input[name="lintang"]').val(getValue('lintang'));
            form.find('input[name="bujur"]').val(getValue('bujur'));

            // Informasi Orang Tua
            form.find('input[name="nama_ayah"]').val(getValue('nama_ayah'));
            form.find('input[name="nik_ayah"]').val(getValue('nik_ayah'));
            form.find('input[name="tahun_lahir_ayah"]').val(getValue('tahun_lahir_ayah'));
            form.find('input[name="pendidikan_ayah"]').val(getValue('pendidikan_ayah'));
            form.find('input[name="pekerjaan_ayah"]').val(getValue('pekerjaan_ayah'));
            form.find('input[name="penghasilan_bulanan_ayah"]').val(getValue('penghasilan_bulanan_ayah'));

            form.find('input[name="nama_ibu_sesuai_ktp"]').val(getValue('nama_ibu_sesuai_ktp'));
            form.find('input[name="nik_ibu"]').val(getValue('nik_ibu'));
            form.find('input[name="tahun_lahir_ibu"]').val(getValue('tahun_lahir_ibu'));
            form.find('input[name="pendidikan_ibu"]').val(getValue('pendidikan_ibu'));
            form.find('input[name="pekerjaan_ibu"]').val(getValue('pekerjaan_ibu'));
            form.find('input[name="penghasilan_bulanan_ibu"]').val(getValue('penghasilan_bulanan_ibu'));

            // Alamat & Kontak Orang Tua
            form.find('textarea[name="alamat_ortu_sesuai_kk"]').val(getValue('alamat_ortu_sesuai_kk'));
            form.find('input[name="kelurahan_ortu"]').val(getValue('kelurahan_ortu'));
            form.find('input[name="kecamatan_ortu"]').val(getValue('kecamatan_ortu'));
            form.find('input[name="kabupaten_ortu"]').val(getValue('kabupaten_ortu'));
            form.find('input[name="no_kartu_keluarga"]').val(getValue('no_kartu_keluarga'));
            form.find('input[name="tinggal_bersama"]').val(getValue('tinggal_bersama'));
            form.find('input[name="transportasi_ke_sekolah"]').val(getValue('transportasi_ke_sekolah'));
            form.find('input[name="nomor_telepon_orang_tua"]').val(getValue('nomor_telepon_orang_tua'));

            // Informasi Wali
            form.find('input[name="nama_wali"]').val(getValue('nama_wali'));
            form.find('input[name="nik_wali"]').val(getValue('nik_wali'));
            form.find('input[name="tahun_lahir_wali"]').val(getValue('tahun_lahir_wali'));
            form.find('input[name="pendidikan_wali"]').val(getValue('pendidikan_wali'));
            form.find('input[name="pekerjaan_wali"]').val(getValue('pekerjaan_wali'));
            form.find('input[name="penghasilan_bulanan_wali"]').val(getValue('penghasilan_bulanan_wali'));
            form.find('textarea[name="alamat_wali"]').val(getValue('alamat_wali'));
            form.find('input[name="rt_wali"]').val(getValue('rt_wali'));
            form.find('input[name="rw_wali"]').val(getValue('rw_wali'));
            form.find('input[name="desa_kelurahan_wali"]').val(getValue('desa_kelurahan_wali'));
            form.find('input[name="kecamatan_wali"]').val(getValue('kecamatan_wali'));
            form.find('input[name="kabupaten_wali"]').val(getValue('kabupaten_wali'));
            form.find('input[name="kode_pos_wali"]').val(getValue('kode_pos_wali'));
            form.find('input[name="nomor_telepon_wali"]').val(getValue('nomor_telepon_wali'));

            // -------------------------------------------------------------------
            // MENGISI SELECT / DROPDOWN
            // -------------------------------------------------------------------
            // .change() penting untuk memicu update pada library seperti Select2
            form.find('select[name="tahun_pelajaran_id"]').val(getValue('tahun_pelajaran_id')).change();
            form.find('select[name="jenis_kelamin"]').val(getValue('jenis_kelamin')).change();
            form.find('select[name="agama"]').val(getValue('agama')).change();
            form.find('select[name="status_daftar"]').val(getValue('status_daftar')).change();

            // -------------------------------------------------------------------
            // MENAMPILKAN NAMA FILE YANG SUDAH DIUPLOAD
            // -------------------------------------------------------------------
            // Hanya tampilkan nama file dari database jika tidak ada old input untuk file tsb.
            if (!hasOldData && siswa.foto) {
                $('#file-info').text(siswa.foto);
                $('.view-foto').removeClass('d-none');
                $('#view-foto').attr('href', "{{ asset('foto_siswa') }}" + '/' + siswa.foto);
            }

            if (!hasOldData && siswa.akta_lahir_path) {
                $('#file-info-akta').text(siswa.akta_lahir_path);
                $('.view-akta').removeClass('d-none');
                $('#view-akta').attr('href', "{{ asset('akta_lahir_path') }}" + '/' + siswa.akta_lahir_path);
            }
        });
    </script>
@endpush
