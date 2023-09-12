<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Stock;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MidtransCallback extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $serverKey = config("midtrans.server_key");
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement') {
                    try {
                        DB::beginTransaction();
                        $payment = Payment::lockForUpdate()->find($request->order_id);
                        if ($payment) {
                            if ($payment->status == "unpaid" or $payment->status == 'belum memilih pembayaran') {
                                $payment->update(['status' => "paid"]);
                                $transaksi = Transaksi::find($payment->transaksi_id);
                                $transaksi->update(['status' => 'pesanan sedang diproses']);
                                $transaksi_details = TransaksiDetail::where('transaksi_id', $payment->transaksi_id)->first();
                                $stock = Stock::lockForUpdate()->find($transaksi_details->stocks_id);

                                if ($stock && $stock->stock >= $transaksi_details->jumlah) {
                                    $reduce_stock = $stock->stock - $transaksi_details->jumlah;
                                    $stock->update(['stock' => $reduce_stock]);

                                    DB::commit();
                                    return response()->json(['message' => 'Stok berhasil dikurangi'], 200);
                                } else {
                                    DB::rollBack();
                                    return response()->json(['message' => 'Stok tidak mencukupi'], 500);
                                }
                            } else {
                                // Pembayaran telah diproses sebelumnya, tidak perlu dilakukan apa-apa.
                                DB::commit();
                                return response()->json(['message' => 'Pembayaran telah diproses sebelumnya'], 200);
                            }
                        } else {
                            DB::rollBack();
                            return response()->json(['message' => 'Data pembayaran tidak ditemukan'], 404);
                        }
                    } catch (\Exception $e) {
                        DB::rollBack();
                    }
                

                // Jika mencapai batas percobaan dan masih gagal, berikan respons error
                return response()->json(['message' => 'Gagal mengurangi stok setelah beberapa percobaan'], 500);
            } else if ($request->transaction_status == 'pending') {
                try {
                    DB::beginTransaction();
                    $payment = Payment::lockForUpdate()->find($request->order_id);
                    if ($payment) {
                        if ($payment->status == "unpaid" or $payment->status == 'belum memilih pembayaran') {
                            $payment->update(['status' => "paid"]);
                            $transaksi = Transaksi::find($payment->transaksi_id);
                            $transaksi->update(['status' => 'pesanan sedang diproses']);
                            $transaksi_details = TransaksiDetail::where('transaksi_id', $payment->transaksi_id)->first();
                            $stock = Stock::lockForUpdate()->find($transaksi_details->stocks_id);

                            if ($stock && $stock->stock >= $transaksi_details->jumlah) {
                                $reduce_stock = $stock->stock - $transaksi_details->jumlah;
                                $stock->update(['stock' => $reduce_stock]);

                                DB::commit();
                                return response()->json(['message' => 'Stok berhasil dikurangi'], 200);
                            } else {
                                DB::rollBack();
                                return response()->json(['message' => 'Stok tidak mencukupi'], 500);
                            }
                        } else {
                            // Pembayaran telah diproses sebelumnya, tidak perlu dilakukan apa-apa.
                            DB::commit();
                            return response()->json(['message' => 'Pembayaran telah diproses sebelumnya'], 200);
                        }
                    } else {
                        DB::rollBack();
                        return response()->json(['message' => 'Data pembayaran tidak ditemukan'], 404);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            } else if ($request->transaction_status == 'expire') {
                try {
                    DB::beginTransaction();
                    $payment = Payment::lockForUpdate()->find($request->order_id);
                    if ($payment) {
                        if ($payment->status == "unpaid" or $payment->status == 'belum memilih pembayaran') {
                            $payment->update(['status' => "expire"]);
                            DB::commit();
                            return response()->json(['message' => 'Status pembayaran expire'], 200);
                        }
                    } else {
                        DB::rollBack();
                        return response()->json(['message' => 'Data pembayaran tidak ditemukan'], 404);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            } else if ($request->transaction_status == 'cancel') {
                try {
                    DB::beginTransaction();
                    $payment = Payment::lockForUpdate()->find($request->order_id);
                    if ($payment) {
                        if ($payment->status == "unpaid" or $payment->status == 'belum memilih pembayaran') {
                            $payment->update(['status' => "cancel"]);
                            DB::commit();
                            return response()->json(['message' => 'Status pembayaran cancel'], 200);
                        }
                    } else {
                        DB::rollBack();
                        return response()->json(['message' => 'Data pembayaran tidak ditemukan'], 404);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
        }
    }
}
