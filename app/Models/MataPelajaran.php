<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table    = "mata_pelajaran";
    protected $fillable = ["nama", "kode", "status", "kelas_id"];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kurikulumDetail()
    {
        return $this->hasMany(KurikulumDetail::class);
    }

    public function komponenNilai()
    {
        return $this->hasMany(KomponenNilai::class);
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

}
