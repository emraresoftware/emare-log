<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtomatikCekim extends Model
{
    use HasFactory;

    protected $table = 'otomatik_cekimler';

    protected $fillable = [
        'musteri_id',
        'kart_no_son4',
        'tutar',
        'cekim_tarihi',
        'durum',
        'hata_mesaji',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'cekim_tarihi' => 'date',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
