<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verici extends Model
{
    use HasFactory;

    protected $table = 'vericiler';

    protected $fillable = [
        'istasyon_id',
        'ad',
        'marka',
        'model',
        'ip_adresi',
        'frekans',
        'aktif',
        'aciklama',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function istasyon()
    {
        return $this->belongsTo(Istasyon::class, 'istasyon_id');
    }
}
