<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Message\MessageResource;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditStockController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreStockRequest $request, Stock $stock, MessageResource $messageResource, $id)
    {
        try {
            DB::beginTransaction();
            // $stockData = Stock::where('products_id', $id)->get();
            // $request->validated();
            // $stocksData = $request->input('stocks');
            // foreach ($stocksData as $stock) {
            //     $createStock = $stock->update([
            //         "size"=>$stock['size'],
            //         "stock"=>$stock['stock'],
            //     ]);
            // }

            $request->validated();
            $stocksInputs = $request->input('stocks');
     $stockData = Stock::where('products_id', $id)->get();
            foreach ($stockData as $index => $stock) {
                $stockId = $stock->id;
                $updateStock = Stock::find($stockId);
                if ($updateStock) {
                    $updateStock->update($stocksInputs[$index]);
                }
            }
            DB::commit();
            return $messageResource->print("success", "Stock berhasil diperbarui", 200);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return $messageResource->print("error", "Stock gagal diperbarui", 400);

        }
    }
}
