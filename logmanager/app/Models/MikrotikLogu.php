<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MikrotikLogu extends Model
{
    use HasFactory;

    protected $table = 'mikrotik_loglari';

    protected $fillable = [
        'mikrotik_id',
        'seviye',
        'mesaj',
    ];

    public function mikrotik()
    {
        return $this->belongsTo(Mikrotik::class, 'mikrotik_id');
    }
}
