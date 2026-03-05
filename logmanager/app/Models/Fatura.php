<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fatura extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faturalar';

    protected $fillable = [
        'fatura_no',
        'musteri_id',
        'bayi_id',
        'tip',
        'tutar',
        'kdv_tutar',
        'toplam_tutar',
        'kdv_orani',
        'fatura_tarihi',
        'son_odeme_tarihi',
        'odeme_tarihi',
        'durum',
        'e_fatura',
        'e_fatura_no',
        'e_fatura_durum',
        'aciklama',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'kdv_tutar' => 'decimal:2',
        'toplam_tutar' => 'decimal:2',
        'fatura_tarihi' => 'date',
        'son_odeme_tarihi' => 'date',
        'odeme_tarihi' => 'date',
        'e_fatura' => 'boolean',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }

    public function bayi()
    {
        return $this->belongsTo(User::class, 'bayi_id');
    }

    public function odemeler()
    {
        return $this->hasMany(Odeme::class, 'fatura_id');
    }
}
