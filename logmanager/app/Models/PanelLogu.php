<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelLogu extends Model
{
    use HasFactory;

    protected $table = 'panel_loglari';

    protected $fillable = [
        'user_id',
        'islem',
        'detay',
        'ip_adresi',
        'modul',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
