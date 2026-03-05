<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HavaleBildirimi extends Model
{
    use HasFactory;

    protected $table = 'havale_bildirimleri';

    protected $fillable = [
        'musteri_id',
        'tutar',
        'banka',
        'referans_no',
        'havale_tarihi',
        'durum',
        'not',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'havale_tarihi' => 'date',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
