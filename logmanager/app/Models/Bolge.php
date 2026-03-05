<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bolge extends Model
{
    use HasFactory;

    protected $table = 'bolgeler';

    protected $fillable = [
        'ad',
        'aciklama',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'bolge_id');
    }

    public function musteriler()
    {
        return $this->hasMany(Musteri::class, 'bolge_id');
    }
}
