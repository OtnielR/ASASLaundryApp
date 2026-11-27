<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $fillable = [
        'nama_paket',
        'satuan',
        'harga',
    ];

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}
