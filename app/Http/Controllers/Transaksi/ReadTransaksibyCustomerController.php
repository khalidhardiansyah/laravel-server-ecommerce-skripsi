<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiCustomerResource;
use App\Models\Payment;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadTransaksibyCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user()->id;
        $transaksis = Transaksi::where('user_id', $user)->get();

        foreach ($transaksis as $transaksi) {
            $payments = Payment::where('transaksi_id', $transaksi->id)
                ->where('status', 'belum memilih metode pembayaran')
                ->where('expire', '<', now())
                ->get();
        
            // Iterasi setiap payment dan perbarui statusnya
            foreach ($payments as $payment) {
                DB::table('payments')
                    ->where('id', $payment->id)
                    ->update(['status' => 'expire']);
            }
        }
        $transaksi = Transaksi::where("user_id", $user)->with(['transaksiDetail.product','transaksiDetail.stock','payment',])->get();
        return TransaksiCustomerResource::collection($transaksi);
    }
}
