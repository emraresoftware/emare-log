<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoklar';

    protected $fillable = [
        'ad',
        'kod',
        'barkod',
        'kategori',
        'miktar',
        'minimum_miktar',
        'alis_fiyati',
        'satis_fiyati',
        'aciklama',
        'aktif',
    ];

    protected $casts = [
        'alis_fiyati' => 'decimal:2',
        'satis_fiyati' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function urunler()
    {
        return $this->hasMany(Urun::class, 'stok_id');
    }
}
