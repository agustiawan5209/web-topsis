<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatifs';
    protected $fillable = [
        'nama',
    ];

    public function penilaians(){
        return $this->hasMany(Penilaian::class, 'alternatif_id', 'id');
    }

     //  FIlter Data User
     public function scopeFilter($query, $filter)
     {
         $query->when($filter['search'] ?? null, function ($query,$search)  {
             $query->where('nama', 'like', '%' . $search . '%');
         })->when($filter['order'] ?? null, function ($query,$order)  {
             $query->orderBy('id', $order);
         });
     }
}
