<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiDetail extends Model
{
    use HasFactory;

    protected $table   = 'nilai_detail';
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function komponenNilai()
    {
        return $this->belongsTo(KomponenNilai::class, 'komponen_nilai_id');
    }
}
