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

}
