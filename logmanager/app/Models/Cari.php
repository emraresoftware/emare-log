<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cari extends Model
{
    use HasFactory;

    protected $table = 'cariler';

    protected $fillable = [
        'ad',
        'unvan',
        'vergi_no',
        'vergi_dairesi',
        'telefon',
        'email',
        'adres',
        'bakiye',
        'aktif',
    ];

    protected $casts = [
        'bakiye' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function faturalar()
    {
        return $this->hasMany(CariFatura::class, 'cari_id');
    }
}
