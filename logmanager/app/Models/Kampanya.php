<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kampanya extends Model
{
    use HasFactory;

    protected $table = 'kampanyalar';

    protected $fillable = [
        'ad',
        'aciklama',
        'indirim_orani',
        'indirim_tutar',
        'baslangic_tarihi',
        'bitis_tarihi',
        'aktif',
    ];

    protected $casts = [
        'indirim_orani' => 'decimal:2',
        'indirim_tutar' => 'decimal:2',
        'baslangic_tarihi' => 'date',
        'bitis_tarihi' => 'date',
        'aktif' => 'boolean',
    ];
}
