<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensi_id')->constrained('absensi');
            $table->foreignId('siswa_id')->constrained('siswa');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
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
        Schema::dropIfExists('absensi_detail');
    }
}
