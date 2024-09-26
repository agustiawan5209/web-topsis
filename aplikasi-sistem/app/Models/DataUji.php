<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataUji extends Model
{
    use HasFactory;

    protected $table = 'data_ujis';

    protected $fillable = [
        'user_id',
        'user',
        'tgl_uji',
        'hasil',
    ];


    protected $casts = [
        'user'=> 'json',
        'hasil'=> 'json',
    ];

    protected $appends = [
        'nama_pengguna',
    ];

    public function namaPengguna():Attribute
    {
        return new Attribute(
            get: fn()=> $this->user['name'],
            set: null,
        );
    }

    public function scopeFilterBySearch($query, $search)
    {
        $query->when($search ?? null, function ($query, $search) {
            $query->where('tgl_uji', 'like', '%' . $search . '%');
        });
    }

    public function scopeFilterByOrder($query, $order)
    {
        $query->when($order ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
    public function scopeFilterByDate($query, $date)
    {
        $query->when($date ?? null, function ($query, $date) {
            $query->whereDate('tgl_uji', $date);
        });
    }

    public function scopeFilterByRole($query)
    {
        $query->when(Auth::user()->hasRole('Pengguna'), function ($query) {
            $query->where('user_id', Auth::user()->id);
        });
    }
}
