<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GelirGider extends Model
{
    use HasFactory;

    protected $table = 'gelir_giderler';

    protected $fillable = [
        'kasa_id',
        'user_id',
        'tip',
        'kategori',
        'tutar',
        'tarih',
        'aciklama',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'tarih' => 'date',
    ];

    public function kasa()
    {
        return $this->belongsTo(Kasa::class, 'kasa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
