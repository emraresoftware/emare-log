<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAdresi extends Model
{
    use HasFactory;

    protected $table = 'ip_adresleri';

    protected $fillable = [
        'mikrotik_id',
        'musteri_id',
        'ip_adresi',
        'subnet',
        'durum',
        'statik',
    ];

    protected $casts = [
        'statik' => 'boolean',
    ];

    public function mikrotik()
    {
        return $this->belongsTo(Mikrotik::class, 'mikrotik_id');
    }

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
