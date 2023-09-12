<?php

namespace App\Http\Controllers\Product;
use App\Models\Products;
use App\Models\Stock;
use App\Http\Resources\BaseMessageResource;
use App\Http\Controllers\Controller;
use App\Message\MessageResource;
use Illuminate\Http\Request;

class DeleteStockProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $idStock, MessageResource $messageResource)
    {
        
            $stock = Stock::find($idStock);
            $stock->delete();
            return $messageResource->print("success","Stock berhasil dihapus",204);
        
    }
}
