<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
use App\Models\User;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'products_id',
        'stocks_id',
        'jumlah_item'
    ];

    // public function user()
    // {
    //     return $this->hasMany(User::class);
    // }
    
    public function user()
    {
        return $this->belongsTo(User::class);
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
