<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboneLogu extends Model
{
    use HasFactory;

    protected $table = 'abone_loglari';

    protected $fillable = [
        'musteri_id',
        'islem',
        'detay',
        'ip_adresi',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
