<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasWali extends Model
{
    use HasFactory;

    protected $table   = 'kelas_wali';
    protected $guarded = [];

    public function sub()
    {
        return $this->belongsTo(KelasSub::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
