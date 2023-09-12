<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function getProvinces()
    {
        
        $response = Http::withHeaders([
            'key' => env('API_RAJA_ONGKIR')
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get All Provinces',
            'data'    => $provinces    
        ]);
    }
    

    public function getCities($id)
    {
        
        $response = Http::withHeaders([
            'key' =>env('API_RAJA_ONGKIR')
        ])->get('https://api.rajaongkir.com/starter/city?&province='.$id.'');

        $cities = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get City By ID Provinces : '.$id,
            'data'    => $cities    
        ]);
    }

    public function cekOngkir(Request $request)
    {
       $response =  Http::withHeaders([
            'key'=>env('API_RAJA_ONGKIR')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            "origin"=>"39",
            "destination"=> $request->tujuan,
            "weight"=>1700,
            "courier"=>$request->kurir
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Result Cost Ongkir',
            'data'    => $response['rajaongkir']['results']
        ]);
    }
}
