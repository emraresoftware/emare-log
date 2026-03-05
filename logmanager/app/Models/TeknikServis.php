<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknikServis extends Model
{
    use HasFactory;

    protected $table = 'teknik_servisler';

    protected $fillable = [
        'musteri_id',
        'atanan_user_id',
        'olusturan_user_id',
        'baslik',
        'aciklama',
        'oncelik',
        'durum',
        'cozum_notu',
        'planlanan_tarih',
        'tamamlanma_tarihi',
    ];

    protected $casts = [
        'planlanan_tarih' => 'datetime',
        'tamamlanma_tarihi' => 'datetime',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }

    public function atananUser()
    {
        return $this->belongsTo(User::class, 'atanan_user_id');
    }

    public function olusturanUser()
    {
        return $this->belongsTo(User::class, 'olusturan_user_id');
    }

    public function isEmirleri()
    {
        return $this->hasMany(IsEmri::class, 'teknik_servis_id');
    }
}
