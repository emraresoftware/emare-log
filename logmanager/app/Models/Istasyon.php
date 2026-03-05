<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Istasyon extends Model
{
    use HasFactory;

    protected $table = 'istasyonlar';

    protected $fillable = [
        'ad',
        'konum',
        'enlem',
        'boylam',
        'aciklama',
        'aktif',
    ];

    protected $casts = [
        'enlem' => 'decimal:7',
        'boylam' => 'decimal:7',
        'aktif' => 'boolean',
    ];

    public function vericiler()
    {
        return $this->hasMany(Verici::class, 'istasyon_id');
    }

    public function genelArizalar()
    {
        return $this->hasMany(GenelAriza::class, 'istasyon_id');
    }
}
