<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Resources\BaseMessageResource;
use App\Http\Resources\TransaksiResource;
use App\Message\MessageResource;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::with(['user', 'transaksiDetail.product', 'transaksiDetail.stock','payment',])->orderBy('created_at', 'desc') ->get();
        return TransaksiResource::collection($transaksi);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreTransaksiRequest $transaksirequest, Transaksi $transaksi, MessageResource $messageResource)
    {
        $this->authorize('create', $transaksi);
        try {
            DB::beginTransaction();
            $transaksi = $transaksirequest->user()->transaksi()->create($transaksirequest->validated());
            $userId = $transaksirequest->user()->id;
            $carts = Cart::where('user_id', $userId)->get();
            $total_pembayaran = null;
            foreach ($carts as $cart) {
                $total_harga = $cart->product->harga_jual * $cart->jumlah_item;
                $total_pembayaran += $total_harga;
                $transaksi_details = $transaksi->transaksiDetail()->create([
                    'products_id' => $cart->products_id,
                    'transaksi_id' => $transaksi->id,
                    'stocks_id' => $cart->stocks_id,
                    'jumlah' => $cart->jumlah_item,
                    'total_harga' => $total_harga,
                ]);

                $cart->delete();
            }
            $total_pembayaran += $transaksi->biaya_pengiriman;

            $payment = Payment::create([
                'transaksi_id' => $transaksi->id,
                "total_pembayaran" => $total_pembayaran,
                'status'=>"unpaid",
                "expire"=> Carbon::parse($transaksi->created_at)->addDay()
            ]);


            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = config("midtrans.production");
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $payment->id,
                    'gross_amount' => $total_pembayaran,
                ),
                'customer_details' => array(
                    'first_name' => $transaksirequest->user()->name,
                    'email' => $transaksirequest->user()->email,
                    'phone' => $transaksirequest->user()->no_hp,
                ),
            );
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $token_midtrans = $payment->update([
                "token_midtrans"=>$snapToken
            ]);
            DB::commit();
            // return $messageResource->print("success", $snapToken, 200);
            $transaksi_Id = Transaksi::with(['user', 'transaksiDetail.product', 'payment',])->find($transaksi->id);
            return new TransaksiResource($transaksi_Id);
        } catch (\Throwable $th) {
            // throw $th;
            echo $th;
            DB::rollBack();
            return $messageResource->print("error", "Transaksi gagal", 500);
        }
    }

    public function destroy($id, MessageResource $messageResource)
    {
        $transaksi =  Transaksi::find($id);
        $transaksi->delete();
        return $messageResource->print("success", "Berhasil dihapus", 200);

        
        
    }

}
