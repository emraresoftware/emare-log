<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CariFatura extends Model
{
    use HasFactory;

    protected $table = 'cari_faturalari';

    protected $fillable = [
        'cari_id',
        'fatura_no',
        'tip',
        'tutar',
        'kdv',
        'toplam',
        'fatura_tarihi',
        'vade_tarihi',
        'durum',
        'aciklama',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'kdv' => 'decimal:2',
        'toplam' => 'decimal:2',
        'fatura_tarihi' => 'date',
        'vade_tarihi' => 'date',
    ];

    public function cari()
    {
        return $this->belongsTo(Cari::class, 'cari_id');
    }
}
