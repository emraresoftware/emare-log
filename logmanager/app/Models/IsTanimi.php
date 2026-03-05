<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsTanimi extends Model
{
    use HasFactory;

    protected $table = 'is_tanimlari';

    protected $fillable = [
        'ad',
        'aciklama',
        'ucret',
        'aktif',
    ];

    protected $casts = [
        'ucret' => 'decimal:2',
        'aktif' => 'boolean',
    ];
}
