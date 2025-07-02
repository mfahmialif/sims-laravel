<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table  = 'guru';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kepalaSekolah()
    {
        return $this->hasMany(KepalaSekolah::class, 'guru_id');
    }

    public function kelasWali()
    {
        return $this->hasMany(KelasWali::class, 'guru_id');
    }
}
