<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $guarded = [];

    public function kelasSub()
    {
        return $this->belongsTo(KelasSub::class);
    }

    public function kurikulumDetail(){
        return $this->belongsTo(KurikulumDetail::class);
    }

    public function guru(){
        return $this->belongsTo(Guru::class);
    }
}
