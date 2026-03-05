<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappAyari extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_ayarlari';

    protected $fillable = [
        'api_url',
        'api_key',
        'telefon_no',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    protected $hidden = [
        'api_key',
    ];
}
