<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
protected $fillable = [
        'kode_invoice',
        'nama_pelanggan',
        'paket_id',
        'user_id',
        'berat_atau_jumlah',
        'total_harga',
        'status_bayar',
        'status_cucian',
        'tanggal_masuk',
        'tanggal_selesai',
    ];

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
