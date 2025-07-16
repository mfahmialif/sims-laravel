<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $guarded = [];

    public function jadwal(){
        return $this->belongsTo(Jadwal::class);
    }

    public function detail(){
        return $this->hasMany(AbsensiDetail::class, 'absensi_id');
    }
}
