<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilai_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa');
            $table->foreignId('jadwal_id')->constrained('jadwal');
            $table->foreignId('komponen_nilai_id')->constrained('komponen_nilai');
            $table->string('nilai');
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('nilai_detail');
    }
};
