<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table  = 'siswa';
    protected $guarad = [];

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'siswa_id');
    }

    public function absensiDetail()
    {
        return $this->hasMany(AbsensiDetail::class, 'siswa_id');
    }

    public function nilaiDetail()
    {
        return $this->hasMany(NilaiDetail::class, 'siswa_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    public function kurikulum(){
        return $this->belongsTo(Kurikulum::class);
    }
}
