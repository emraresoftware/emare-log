<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devre extends Model
{
    use HasFactory;

    protected $table = 'devreler';

    protected $fillable = [
        'ad',
        'devre_no',
        'saglayici',
        'kapasite',
        'aylik_ucret',
        'aktif',
        'aciklama',
    ];

    protected $casts = [
        'aylik_ucret' => 'decimal:2',
        'aktif' => 'boolean',
    ];
}
