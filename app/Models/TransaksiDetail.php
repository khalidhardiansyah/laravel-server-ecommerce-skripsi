<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'products_id',
        'transaksi_id',
        'jumlah',
        'total_harga',
        'stocks_id'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, "transaksi_id", 'id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id', 'id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stocks_id', 'id');
    }
}
