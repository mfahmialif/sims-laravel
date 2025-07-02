<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    use HasFactory;

    protected $table   = 'kelas_siswa';
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(KelasSiswa::class);
    }

    public function sub()
    {
        return $this->belongsTo(KelasSub::class);
    }
}
