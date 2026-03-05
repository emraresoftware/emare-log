<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AramaEmri extends Model
{
    use HasFactory;

    protected $table = 'arama_emirleri';

    protected $fillable = [
        'musteri_id',
        'user_id',
        'baslik',
        'aciklama',
        'durum',
        'sonuc_notu',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
