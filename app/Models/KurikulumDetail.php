<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumDetail extends Model
{
    use HasFactory;
    protected $table   = "kurikulum_detail";
    protected $guarded = [];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }
    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'kurikulum_detail_id');
    }
}
