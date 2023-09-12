<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Cart;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'size',
        'stock',
        'products_id',
       
    ];

    protected $foreignKey = 'products_id';
    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id', 'id',);
    }

    public function carts()
{
    return $this->hasMany(Cart::class, 'stocks_id', 'id');
}

public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'stocks_id', 'id');
    }
}
