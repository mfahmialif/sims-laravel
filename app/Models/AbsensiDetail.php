<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiDetail extends Model
{
    use HasFactory;

    protected $table = 'absensi_detail';
    protected $guarded = [];

    public function absensi(){
        return $this->belongsTo(Absensi::class);
    }

    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }
}
