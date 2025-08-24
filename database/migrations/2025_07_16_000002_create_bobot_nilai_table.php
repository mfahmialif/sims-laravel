<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bobot_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal');
            $table->foreignId('komponen_nilai_id')->constrained('komponen_nilai');
            $table->float('bobot');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('bobot_nilai');
    }
};
