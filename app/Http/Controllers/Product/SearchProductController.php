<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Message\MessageResource;
use App\Models\Products;
use Illuminate\Http\Request;

class SearchProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, MessageResource $messageResource)
    {
        $keyword = $request->input('keyword');
        $result = Products::where("nama_barang",'like', '%' . $keyword . '%')->get();
        if (!empty($keyword)) {
            $result = Products::where("nama_barang", 'like', '%' . $keyword . '%')->get();
            if ($result->isEmpty()) {
                return $messageResource->print("error", "data tidak ditemukan", 400);
             } else {
                 return ProductResource::collection($result);
             }
        } else {
            $result = [];
        }
        
        

    }
}
