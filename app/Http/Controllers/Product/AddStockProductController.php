<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Http\Resources\BaseMessageResource;
use App\Message\MessageResource;
use App\Models\Stock;

class AddStockProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id ,StoreStockRequest $request, MessageResource $messageResource)
    {
        $request->validated();
            $stocksData = $request->input('stocks');
            foreach ($stocksData as $stock) {
                $createStock = Stock::create(
                    [
                        "size"=>$stock['size'],
                        "stock"=>$stock['stock'],
                        "products_id"=>$id
                    ]
                );
            }
        return $messageResource->print("success", "Berhasil membuat stock", 201);
    }
}
