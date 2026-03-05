<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depo extends Model
{
    use HasFactory;

    protected $table = 'depolar';

    protected $fillable = [
        'ad',
        'konum',
        'aciklama',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function urunler()
    {
        return $this->hasMany(Urun::class, 'depo_id');
    }
}
