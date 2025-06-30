<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $table ="kurikulum";
    protected $fillable =["tahun_pelajaran_id","mata_pelajaran_id"];
}
