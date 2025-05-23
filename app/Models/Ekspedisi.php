<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ekspedisi',
        'biaya'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
