<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable =[
        'transaksi_id',
"metode",
"total_pembayaran",
"status",
"token_midtrans",
"expire"
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     self::creating(function ($payment) {
    //         // Jika nilai 'expire' tidak diset, atur nilai berdasarkan 'created_at' ditambah 1 hari
    //         if (!$payment->expire) {
    //             $payment->expire = $payment->created_at->addDay();
    //         }
    //     });
    // }
}
