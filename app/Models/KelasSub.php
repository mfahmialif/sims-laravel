<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasSub extends Model
{
    use HasFactory;

    protected $table   = 'kelas_sub';
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function siswa()
    {
        return $this->hasMany(KelasSiswa::class, 'kelas_sub_id');
    }

    public function wali()
    {
        return $this->hasMany(KelasWali::class, 'kelas_sub_id');
    }
}
