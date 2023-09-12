<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class alamat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_pos',
        'alamat_detail',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
    ];

    public function provinsi(){
        return $this->belongsTo(Province::class, 'provinsi_id', 'id');
    }

    public function kabupaten(){
        return $this->belongsTo(City::class,  'kabupaten_id','id');
    }

    public function kecamatan(){
        return $this->belongsTo(District::class,  'kecamatan_id','id');
    }

    public function kelurahan(){
        return $this->belongsTo(Village::class,  'kelurahan_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
