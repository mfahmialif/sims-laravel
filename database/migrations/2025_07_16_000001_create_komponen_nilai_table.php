<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('komponen_nilai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['pengetahuan', 'keterampilan', 'sikap']);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('komponen_nilai');
    }
};
