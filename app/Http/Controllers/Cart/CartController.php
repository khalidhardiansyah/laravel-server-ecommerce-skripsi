<?php

namespace App\Http\Controllers\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Models\User;
use App\Http\Resources\BaseMessageResource;
use App\Message\MessageResource;
use App\Models\Cart;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user()->id;
        $carts = Cart::with(['stock', 'product'])->where("user_id", $user)->get();
        foreach ($carts as $cart) {
            $this->authorize("view",$cart);
        }
        return CartResource::collection($carts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartRequest $request, MessageResource $messageResource)
    {
        $this->authorize("create", Cart::class);
        $validate = $request->validated();
        $stock_id = $validate['stocks_id'];
        $product_id = $validate['products_id'];
        $stock_in_cart = Cart::with(["stock", "product"])->where("stocks_id", $stock_id)->where("user_id", $request->user()->id)->where("products_id", $product_id)->get();
        $is_stock_in_cart = Cart::with(["stock", "product"])->where("stocks_id", $stock_id)->where("user_id", $request->user()->id)->where("products_id", $product_id)->exists();
        if ($is_stock_in_cart) {
            return $messageResource->print("error","Produk ".$stock_in_cart[0]['Product']['nama_barang']."dengan size ".$stock_in_cart[0]['stock']['size']." sudah ada didalam cart anda", 400);
       }else{
           $cart = $request->user()->cart()->create($validate);
           return $messageResource->print("success","cart ditambahkan",201);
       }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCartRequest $request, Cart $cart,  MessageResource $messageResource)
    {
        $this->authorize('update', $cart);
        $validate = $request->validated();
        $cart->update($validate);
             return $messageResource->print("success","cart diperbarui",201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart,  MessageResource $messageResource)
    {
        $this->authorize('delete', $cart);
        $cart->delete();
             return $messageResource->print("success","cart dihapur",204);

    }
}
