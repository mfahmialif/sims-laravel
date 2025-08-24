<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenNilai extends Model
{
    use HasFactory;

    protected $table = 'komponen_nilai';
    protected $guarded = [];

    public function bobotNilai()
    {
        return $this->hasMany(BobotNilai::class, 'komponen_id');
    }

    public function nilaiDetails()
    {
        return $this->hasMany(NilaiDetail::class, 'komponen_id');
    }
}
