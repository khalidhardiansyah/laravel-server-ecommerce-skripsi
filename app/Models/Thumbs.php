<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thumbs extends Model
{
    use HasFactory;

    protected $fillable = [
        'path_thumb',
        'products_id'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id', 'id');
    }
}
