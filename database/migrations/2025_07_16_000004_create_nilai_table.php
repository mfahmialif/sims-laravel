<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran');
            $table->enum('jenis', ['pengetahuan', 'keterampilan', 'sikap']);
            $table->string('nilai_akhir');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('nilai');
    }
};
