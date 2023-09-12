<?php

namespace App\Http\Controllers;

use App\Message\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $message = new MessageResource();
        $total_user = DB::table("users", "u")->join("roles", "u.role_id", "=", "roles.id")->where("nama_role", "=", "customer")->count();

        $total_pendapatan = DB::table('transaksis', 't')->join("payments", "t.id", "=", "payments.transaksi_id")->where("payments.status", "=", "paid")
                                                        ->join("transaksi_details", "t.id", "=", "transaksi_details.transaksi_id")
                                                        ->join("products", "transaksi_details.products_id", "=", "products.id")
                                                        ->select("payments.status",
                                                                "transaksi_details.jumlah",
                                                                "products.harga_jual",
                                                                "products.harga_modal")->get();
        $pendapatan_bersih = 0;
        foreach ($total_pendapatan as $pendapatan) {
        $pendapatan_bersih += $pendapatan->jumlah * $pendapatan->harga_jual ;
        }

        $total_transaksi = DB::table("transaksis", "t")->join("payments", "t.id", "=", "payments.transaksi_id")->count();
        $data = [
            "customer" =>$total_user,
            "total_pendapatan" =>$pendapatan_bersih,
            "total_transaksi"=>$total_transaksi
        ];
        return $message->print("data", $data, 200) ;
    }
}
