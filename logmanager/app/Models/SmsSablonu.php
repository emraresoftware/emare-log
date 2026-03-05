<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSablonu extends Model
{
    use HasFactory;

    protected $table = 'sms_sablonlari';

    protected $fillable = [
        'ad',
        'icerik',
        'tip',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
