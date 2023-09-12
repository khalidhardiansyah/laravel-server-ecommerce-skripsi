<?php

namespace App\Http\Controllers;

use App\Message\MessageResource;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use \PDF;
class InvoiceController extends Controller
{
    public function download($id, Request $request, MessageResource $messageResource)
    {
        // $user = $request->user()->id;
        $invoice = Transaksi::with([ "user.alamat",'transaksiDetail.product', 'transaksiDetail.stock',"payment"])->find($id);

        if ($invoice === null) {
            return $messageResource->print("error", "data tidak ada", 400);
        } else {
            // return view("invoice", ["invoice"=>$invoice]);
            $pdf = PDF::loadView("invoice", ["invoice"=>$invoice])->setPaper('a4', 'portrait');
            
        $filename = "Invoice.pdf";
        $response =  $pdf->download($filename);
// 
        // $response->header('Access-Control-Allow-Origin', env('ADMIN_URL'));

        return $response;
        }
        // $pdf = PDF::loadView("invoice", ["invoice"=>$invoice]);
        // $filename = "Invoice.pdf";
        // $response =  $pdf->download($filename);

        // $response->header('Access-Control-Allow-Origin', env('ADMIN_URL'));

        // return $response;
        // Transaksi::where("user_id", $user)->with(['transaksiDetail.product','transaksiDetail.stock','payment',])->get();

        
    }
}
