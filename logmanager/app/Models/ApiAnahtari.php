<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiAnahtari extends Model
{
    use HasFactory;

    protected $table = 'api_anahtarlari';

    protected $fillable = [
        'ad',
        'api_key',
        'api_secret',
        'aktif',
        'son_kullanim',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'son_kullanim' => 'datetime',
    ];

    protected $hidden = [
        'api_secret',
    ];
}
