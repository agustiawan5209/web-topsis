<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaians';
    protected $fillable = [
        'kriteria_id',
        'alternatif_id',
        'nilai',
    ];

    public function kriteria(){
        return $this->hasOne(Kriteria::class, 'id', 'kriteria_id');
    }
}
