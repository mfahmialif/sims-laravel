<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $guarded = [];

    public function tahunPelajaran(){
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function kelasSub()
    {
        return $this->belongsTo(KelasSub::class);
    }

    public function kurikulumDetail(){
        return $this->belongsTo(KurikulumDetail::class);
    }

    public function guru(){
        return $this->belongsTo(Guru::class);
    }

    public function bobotNilai()
    {
        return $this->hasMany(BobotNilai::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function nilaiDetail()
    {
        return $this->hasMany(NilaiDetail::class);
    }

    public function absensi(){
        return $this->hasMany(Absensi::class);
    }
}
