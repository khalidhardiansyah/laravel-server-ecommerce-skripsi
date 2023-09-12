<?php

namespace App\Http\Controllers\Product;

use App\Models\Products;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\StoreThumbRequest;
use App\Http\Resources\BaseMessageResource;
use App\Message\MessageResource;
use App\Models\Stock;
use App\Models\Thumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Products::with(['stocks', 'thumb'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThumbRequest $request, StoreProductsRequest $productrequest, StoreStockRequest $stockrequest, MessageResource $messageResource)
    {
        $this->authorize("create", Products::class);

        try {
            DB::beginTransaction();
            $product = Products::create($productrequest->validated());
            $stockrequest->validated();
            $stocksData = $stockrequest->input('stocks');
            foreach ($stocksData as $stock) {
                $createStock = Stock::create(
                    [
                        "size"=>$stock['size'],
                        "stock"=>$stock['stock'],
                        "products_id"=>$product->id
                    ]
                );
            }
        $request->validated();
        if ($request->has('images')) {
            $path = 'public/product/';
            $i = 1;
            foreach ($request->file('images') as $image) {
                $ext = $image->getClientOriginalExtension();
                $filename = time().$i++.'.'.$ext;
                $image->move($path, $filename);
                $filenamefinal = $path.$filename;
                $pt = $product->thumb()->create(
                    [
                        'path_thumb' =>$filenamefinal,
                        'products_id' =>$product->id
                    ]
                );

            };
            DB::commit();
            return $messageResource->print("success_create","produk berhasil dibuat",201);
        }
        } catch (\Throwable $th) {

            return $messageResource->print("error_create", "produk gagal dibuat",400);
           DB::rollBack();
        }
    }
   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id, MessageResource $messageResource)
    {
        $products =  Products::with('stocks', 'thumb')->find($id);
       if ($products) {
        return new ProductResource($products);
       }
       return $messageResource->print("error","data tidak ditemukan",404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsRequest  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductsRequest $productrequest, MessageResource $messageResource, Products $products)
    {
        $this->authorize("update", $products);
       try {
        DB::beginTransaction();
        $products->update($productrequest->validated());
        DB::commit();
        return $messageResource->print("success_edit","produk berhasil diperbarui",201);
       } catch (\Throwable $th) {
        DB::rollBack();
        return $messageResource->print("error_edit","data tidak ditemukan",404);
       } 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
     public function destroy($id, MessageResource $messageResource,)
    {
        // $this->authorize("delete", $products);

        $product =  Products::find($id);
        if ($product->thumb) {
            foreach ($product->thumb as $image) {
                if (File::exists($image->path_thumb)) {
                    File::delete($image->path_thumb);
                }
            }
            $product->delete();
            return $messageResource->print("success","produk berhasil dihapus",200);
        } else {
            return $messageResource->print("error","data tidak ditemukan",404);
        }
        
    }

  


}
