<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarife extends Model
{
    use HasFactory;

    protected $table = 'tarifeler';

    protected $fillable = [
        'bayi_id',
        'ad',
        'tip',
        'hiz',
        'download_hiz',
        'upload_hiz',
        'fiyat',
        'kdv_dahil_fiyat',
        'kdv_orani',
        'sure_gun',
        'taahhut_suresi',
        'taahhut_cezasi',
        'aktif',
        'aciklama',
    ];

    protected $casts = [
        'fiyat' => 'decimal:2',
        'kdv_dahil_fiyat' => 'decimal:2',
        'taahhut_cezasi' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function bayi()
    {
        return $this->belongsTo(User::class, 'bayi_id');
    }

    public function musteriler()
    {
        return $this->hasMany(Musteri::class, 'tarife_id');
    }
}
