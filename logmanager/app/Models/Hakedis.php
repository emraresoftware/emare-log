<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hakedis extends Model
{
    use HasFactory;

    protected $table = 'hakedisler';

    protected $fillable = [
        'personel_id',
        'donem',
        'tutar',
        'prim',
        'kesinti',
        'net_tutar',
        'aciklama',
        'odendi',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'prim' => 'decimal:2',
        'kesinti' => 'decimal:2',
        'net_tutar' => 'decimal:2',
        'odendi' => 'boolean',
    ];

    public function personel()
    {
        return $this->belongsTo(Personel::class, 'personel_id');
    }
}
