<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotNilai extends Model
{
    use HasFactory;

    protected $table = 'bobot_nilai';
    protected $guarded = [];

    public function jadwal()
    {
        return $this->belongsTo(jadwal::class, 'jadwal_id');
    }

    public function komponenNilai()
    {
        return $this->belongsTo(KomponenNilai::class, 'komponen_id');
    }
}
