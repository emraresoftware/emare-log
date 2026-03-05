<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenelAriza extends Model
{
    use HasFactory;

    protected $table = 'genel_arizalar';

    protected $fillable = [
        'baslik',
        'aciklama',
        'mikrotik_id',
        'istasyon_id',
        'durum',
        'etkilenen_musteri_sayisi',
        'baslangic_zamani',
        'bitis_zamani',
        'cozum_notu',
        'olusturan_user_id',
    ];

    protected $casts = [
        'baslangic_zamani' => 'datetime',
        'bitis_zamani' => 'datetime',
    ];

    public function mikrotik()
    {
        return $this->belongsTo(Mikrotik::class, 'mikrotik_id');
    }

    public function istasyon()
    {
        return $this->belongsTo(Istasyon::class, 'istasyon_id');
    }

    public function olusturanUser()
    {
        return $this->belongsTo(User::class, 'olusturan_user_id');
    }
}
