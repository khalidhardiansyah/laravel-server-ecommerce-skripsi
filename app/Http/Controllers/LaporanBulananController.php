<?php

namespace App\Http\Controllers;

use \PDF;
use App\Message\MessageResource;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanBulananController extends Controller
{
    public function download(Request $request, MessageResource $messageResource)
    {
        $tanggal_start = $request->tanggal_start;
        $tanggal_finish = $request->tanggal_finish;
        $laporan = DB::table('transaksis')->join("payments", "transaksis.id", "=", "payments.transaksi_id")->where("payments.status", "=", "paid")
            ->join("transaksi_details", "transaksis.id", "=", "transaksi_details.transaksi_id")
            ->join("products", "transaksi_details.products_id", "=", "products.id")
            ->join("users", "transaksis.user_id", "=", "users.id")
            ->join("categories", "categories.id", "=", "products.category_id")
            ->select(
                "categories.nama_category",
                "transaksis.order_number",
                "transaksis.kurir",
                "transaksis.service",
                "payments.status",
                "products.nama_barang",
                "products.harga_modal",
                "products.harga_jual",
                "transaksi_details.jumlah",
                "transaksi_details.total_harga",
                "users.name",
            // )->whereBetween("transaksis.created_at", ['2023-07-5', '2023-07-28'])->get();
            )->whereBetween("transaksis.created_at", [$tanggal_start, $tanggal_finish])->get();
        if ($laporan->isEmpty()) {
            return $messageResource->print("error", "Data tidak tersedia", 400);
        } else {
            // return view("laporanbycategory", ["laporan" => $laporan, 'tanggal_start'=>$tanggal_start]);
            $pdf = PDF::loadView("laporanbycategory", ["laporan" => $laporan, 'tanggal_start'=>$tanggal_start]);
            $filename = "LAPORAN_BULANAN.pdf";
            $response =  $pdf->download($filename);

            $response->header('Access-Control-Allow-Origin', env('ADMIN_URL'));

            return $response;

            // return response()->json($laporan);
        }
    }
}
