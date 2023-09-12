<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
use App\Models\Cart;
use App\Models\Thumbs;
use App\Models\Category;
use App\Models\TransaksiDetail;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'harga_jual',
        'harga_modal',
        'category_id'
        
    ];
    // produk memiliki satu categori
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'products_id', 'id');
    }

    public function carts(){
        return $this->hasMany(Cart::class, 'products_id', 'id');
    }

    public function thumb()
    {
        return $this->hasMany(Thumbs::class, 'products_id', 'id');
    }

    public function transaksidetail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }


}
