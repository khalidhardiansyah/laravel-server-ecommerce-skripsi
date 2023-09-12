<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_category',
    ];

//    satu category berisikan banyak produk / memiliki banyak produk
    public function product()
    {
        return $this->hasMany(Products::class, "category_id", "id");
    }
}
