<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odeme extends Model
{
    use HasFactory;

    protected $table = 'odemeler';

    protected $fillable = [
        'fatura_id',
        'musteri_id',
        'user_id',
        'tutar',
        'odeme_yontemi',
        'referans_no',
        'odeme_tarihi',
        'aciklama',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'odeme_tarihi' => 'date',
    ];

    public function fatura()
    {
        return $this->belongsTo(Fatura::class, 'fatura_id');
    }

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
