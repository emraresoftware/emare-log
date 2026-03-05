<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arac extends Model
{
    use HasFactory;

    protected $table = 'araclar';

    protected $fillable = [
        'plaka',
        'marka',
        'model',
        'yil',
        'renk',
        'sorumlu_user_id',
        'muayene_tarihi',
        'sigorta_tarihi',
        'km',
        'aktif',
        'aciklama',
    ];

    protected $casts = [
        'muayene_tarihi' => 'date',
        'sigorta_tarihi' => 'date',
        'km' => 'decimal:0',
        'aktif' => 'boolean',
    ];

    public function sorumluUser()
    {
        return $this->belongsTo(User::class, 'sorumlu_user_id');
    }
}
