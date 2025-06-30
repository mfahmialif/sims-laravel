<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajaran');
            $table->foreignId('user_id')->constrained('users');

            // Student Information
            $table->string('nis')->unique()->nullable();
            $table->string('nisn')->unique()->nullable();
            $table->string('nama_siswa');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('nik_anak')->nullable();
            $table->string('no_registrasi_akta_lahir')->nullable();
            $table->string('akta_lahir_path')->nullable(); // Assuming this is a file path
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara_kandung')->nullable();
            $table->integer('umur_anak')->nullable(); // Can be calculated, but kept for direct input if needed
            $table->string('masuk_sekolah_sebagai')->nullable();
            $table->string('asal_sekolah_tk')->nullable();
            $table->integer('tinggi_badan')->nullable();                  // in cm
            $table->integer('berat_badan')->nullable();                   // in kg
            $table->integer('lingkar_kepala')->nullable();                // in cm
            $table->decimal('jarak_tempuh_ke_sekolah', 8, 2)->nullable(); // in km
            $table->string('gol_darah')->nullable();

            // Student Address
            $table->text('alamat_anak_sesuai_kk');
            $table->string('desa_kelurahan_anak');
            $table->string('kecamatan_anak');
            $table->string('kabupaten_anak');
            $table->string('kode_pos_anak')->nullable();
            $table->string('rt_anak')->nullable();
            $table->string('rw_anak')->nullable();
            $table->decimal('lintang', 10, 7)->nullable();
            $table->decimal('bujur', 10, 7)->nullable();

            // Family Information (Parents)
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->year('tahun_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->decimal('penghasilan_bulanan_ayah', 15, 2)->nullable();

            $table->string('nama_ibu_sesuai_ktp')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->year('tahun_lahir_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->decimal('penghasilan_bulanan_ibu', 15, 2)->nullable();

            // Family Address (assuming same for parents as student if not specified otherwise)
            $table->text('alamat_ortu_sesuai_kk')->nullable();
            $table->string('kelurahan_ortu')->nullable();
            $table->string('kecamatan_ortu')->nullable();
            $table->string('kabupaten_ortu')->nullable();
            $table->string('no_kartu_keluarga')->nullable();

            $table->string('tinggal_bersama')->nullable();
            $table->string('transportasi_ke_sekolah')->nullable();
            $table->string('nomor_telepon_orang_tua')->nullable();

            // Guardian Information (if applicable)
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->year('tahun_lahir_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->decimal('penghasilan_bulanan_wali', 15, 2)->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('rt_wali')->nullable();
            $table->string('rw_wali')->nullable();
            $table->string('desa_kelurahan_wali')->nullable();
            $table->string('kecamatan_wali')->nullable();
            $table->string('kabupaten_wali')->nullable();
            $table->string('kode_pos_wali')->nullable();
            $table->string('nomor_telepon_wali')->nullable();

            $table->enum('status_daftar', ['daftar', 'diterima', 'tidak diterima'])->default('daftar');
            $table->enum('status', ['aktif', 'tidak aktif', 'cuti', 'lulus'])->default('aktif');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
