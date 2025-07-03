<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');

            // Kolom data pribadi dan identitas
            $table->string('nip', 20)->unique();
            $table->string('nama', 150);
            $table->string('nuptk', 20)->unique()->nullable();
            $table->string('npwp', 25)->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('nik', 20)->unique();
            $table->string('no_kk', 20)->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu']);
            $table->string('kewarganegaraan', 50)->default('Indonesia');

            // Kolom data kepegawaian
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'GTY', 'GTT', 'Honorer']);
            $table->enum('jenis_ptk', [
                'Kepala Sekolah',
                'Wakil Kepala Sekolah',
                'Guru Kelas',
                'Guru Mata Pelajaran',
                'Guru Bimbingan Konseling',
                'Guru TIK',
                'Guru Pendamping Khusus',
                'Tenaga Administrasi Sekolah',
                'Pustakawan',
                'Laboran',
                'Teknisi',
                'Penjaga Sekolah',
                'Lainnya',
            ]);
            $table->string('tugas_tambahan', 100)->nullable();
            $table->string('no_sk_cpns', 100)->nullable();
            $table->string('sk_cpns')->nullable();
            $table->date('tanggal_cpns')->nullable();
            $table->string('no_sk_pengangkatan', 100);
            $table->string('sk_pengangkatan')->nullable();
            $table->date('tmt_pengangkatan');
            $table->string('lembaga_pengangkatan', 100);
            $table->string('pangkat_golongan', 50)->nullable();

            // Kolom alamat
            $table->text('alamat_jalan');
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->string('nama_dusun', 100)->nullable();
            $table->string('desa_kelurahan', 100);
            $table->string('kecamatan', 100);
            $table->string('kabupaten', 100);
            $table->string('provinsi', 100);
            $table->string('kodepos', 10)->nullable();

            // Kolom kontak dan lain-lain
            $table->string('no_hp')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');

            // Timestamps (created_at and updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guru');
    }
}
