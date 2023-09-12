<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_number",
        "user_id",
        "kurir",
        "service",
        "biaya_pengiriman",
        "status"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, "transaksi_id", "id");
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            $transaksi->order_number = static::generateOrderNumber();
            $transaksi->status = 'menunggu pembayaran';
        });
    }

    public static function generateOrderNumber()
    {
        $prefix = 'ORD'; // Awalan untuk nomor pesanan
        $randomNumber = mt_rand(100000, 999999); // Nomor acak enam digit

        // Menggabungkan awalan dengan nomor acak
        $orderNumber = $prefix . $randomNumber;

        // Memastikan nomor pesanan unik dengan memeriksa di database
        if (static::where('order_number', $orderNumber)->exists()) {
            // Jika nomor pesanan sudah ada, generate nomor baru secara rekursif
            return static::generateOrderNumber();
        }

        return $orderNumber;
    }
}
