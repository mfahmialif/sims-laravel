<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPelajaran extends Model
{
    use HasFactory;

    protected $table  = 'tahun_pelajaran';
    protected $guarad = [];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'tahun_pelajaran_id');
    }
}
