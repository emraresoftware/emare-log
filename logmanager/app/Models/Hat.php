<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hat extends Model
{
    use HasFactory;

    protected $table = 'hatlar';

    protected $fillable = [
        'mikrotik_id',
        'ad',
        'hat_tipi',
        'kapasite',
        'kullanilan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function mikrotik()
    {
        return $this->belongsTo(Mikrotik::class, 'mikrotik_id');
    }
}
