<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasa extends Model
{
    use HasFactory;

    protected $table = 'kasalar';

    protected $fillable = [
        'ad',
        'kod',
        'bakiye',
        'aciklama',
        'aktif',
    ];

    protected $casts = [
        'bakiye' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function hareketler()
    {
        return $this->hasMany(KasaHareketi::class, 'kasa_id');
    }

    public function gelirGiderler()
    {
        return $this->hasMany(GelirGider::class, 'kasa_id');
    }
}
