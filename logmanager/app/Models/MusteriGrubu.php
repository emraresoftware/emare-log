<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusteriGrubu extends Model
{
    use HasFactory;

    protected $table = 'musteri_gruplari';

    protected $fillable = [
        'ad',
        'renk',
        'aciklama',
    ];

    public function musteriler()
    {
        return $this->belongsToMany(Musteri::class, 'musteri_grup_pivot', 'grup_id', 'musteri_id');
    }
}
