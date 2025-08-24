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
            $table->foreignId('jadwal_id')->constrained('jadwal');
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
