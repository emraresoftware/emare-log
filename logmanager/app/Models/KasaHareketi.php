<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasaHareketi extends Model
{
    use HasFactory;

    protected $table = 'kasa_hareketleri';

    protected $fillable = [
        'kasa_id',
        'user_id',
        'musteri_id',
        'tip',
        'tutar',
        'kategori',
        'aciklama',
        'islem_tarihi',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'islem_tarihi' => 'date',
    ];

    public function kasa()
    {
        return $this->belongsTo(Kasa::class, 'kasa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
