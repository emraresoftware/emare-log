<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsEmri extends Model
{
    use HasFactory;

    protected $table = 'is_emirleri';

    protected $fillable = [
        'teknik_servis_id',
        'musteri_id',
        'atanan_user_id',
        'baslik',
        'aciklama',
        'durum',
        'planlanan_tarih',
        'tamamlanma_tarihi',
    ];

    protected $casts = [
        'planlanan_tarih' => 'datetime',
        'tamamlanma_tarihi' => 'datetime',
    ];

    public function teknikServis()
    {
        return $this->belongsTo(TeknikServis::class, 'teknik_servis_id');
    }

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }

    public function atananUser()
    {
        return $this->belongsTo(User::class, 'atanan_user_id');
    }
}
