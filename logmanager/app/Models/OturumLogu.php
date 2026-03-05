<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OturumLogu extends Model
{
    use HasFactory;

    protected $table = 'oturum_loglari';

    protected $fillable = [
        'musteri_id',
        'kullanici_adi',
        'ip_adresi',
        'mac_adresi',
        'nas_ip',
        'baslangic',
        'bitis',
        'download_bytes',
        'upload_bytes',
        'sonlanma_nedeni',
    ];

    protected $casts = [
        'baslangic' => 'datetime',
        'bitis' => 'datetime',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
