<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Message\MessageResource;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminConfirmPesananController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $status_pesanan = $request->status_pesanan;
        $transaksi = Transaksi::find($id);
        $transaksi->update(["status"=>$status_pesanan]);

    $msg = new MessageResource();
    return $msg->print("success_confirm", "konfirmasi kirim pesanan berhasil", 200);
    }
}
