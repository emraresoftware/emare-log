<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urun extends Model
{
    use HasFactory;

    protected $table = 'urunler';

    protected $fillable = [
        'stok_id',
        'depo_id',
        'musteri_id',
        'seri_no',
        'mac_adresi',
        'durum',
        'aciklama',
    ];

    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id');
    }

    public function depo()
    {
        return $this->belongsTo(Depo::class, 'depo_id');
    }

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
