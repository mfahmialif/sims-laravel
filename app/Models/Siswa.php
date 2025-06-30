<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $guarad = [];

    public function tahunPelajaran(){
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
