<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsAyari extends Model
{
    use HasFactory;

    protected $table = 'sms_ayarlari';

    protected $fillable = [
        'saglayici',
        'kullanici_adi',
        'sifre',
        'baslik',
        'api_key',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    protected $hidden = [
        'sifre',
        'api_key',
    ];
}
