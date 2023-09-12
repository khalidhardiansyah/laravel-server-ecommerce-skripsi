<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Message\MessageResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateTransaksiPaymentCancel extends Controller
{
    public function __invoke(Request $request,$id, MessageResource $messageResource)
    {
        try {
            $payment = Payment::lockForUpdate()->find($id);

            if (!$payment) {
                return $messageResource->print("error", "Data tidak ditemukan", 404);
            }

            if ($payment->status == "belum memilih metode pembayaran") {
                $payment->update(['status' => $request->status]);

                return $messageResource->print("success", "Berhasil diubah", 200);

            }

            DB::beginTransaction();

            if($payment->status = 'unpaid'){
                $payment->update(['status' => $request->status]);

            DB::commit();

            return $messageResource->print("success", "Berhasil diubah", 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            // Contoh penanganan exception yang lebih informatif
            return $messageResource->print("error", "Terjadi kesalahan saat memproses permintaan", 500);
        }
    }
}

