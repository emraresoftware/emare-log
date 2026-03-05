<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hizmet extends Model
{
    use HasFactory;

    protected $table = 'hizmetler';

    protected $fillable = [
        'ad',
        'kod',
        'fiyat',
        'aciklama',
        'aktif',
    ];

    protected $casts = [
        'fiyat' => 'decimal:2',
        'aktif' => 'boolean',
    ];
}
