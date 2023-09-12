<?php

namespace App\Http\Controllers\Alamat;

use App\Http\Controllers\Controller;
use App\Models\alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function provinces()
    {
        return \Indonesia::allProvinces();
    }

    public function findKota(Request $request)
    {
        return \Indonesia::findProvince($request->id, ['cities'])->cities->pluck('name', 'id');
    }

    public function findKecamatan(Request $request)
    {
        return \Indonesia::findCity($request->id, ['districts'])->districts->pluck('name', 'id');
    
    }

    public function findKelurahan(Request $request)
    {
        return \Indonesia::findDistrict($request->id, ['villages'])->villages->pluck('name', 'id');
    
    }
   
}
