<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriterias';
    protected $fillable = [
        'nama',
    ];

    public function subKriteria(){
        return $this->hasMany(SubKriteria::class, 'kriteria_id','id');
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
