<?php

namespace App\Http\Controllers;

use App\Message\MessageResource;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, MessageResource $messageResource)
    {
        $data = $request->validate([
            'token' => 'required',
            "password"=> 'required|min:6',
        ]);
        $hash_password = Hash::make($data['password']);

        $reset = PasswordReset::where('token', $data['token'])->first();
        try {
            DB::beginTransaction();
            if ($reset) {
                $user = User::where("email", $reset->email)->first();
                
                $user->update([
                    "password" => $hash_password
                ]);
                DB::table('password_resets')->where('token', $data['token'])->delete();
                DB::commit();
                return $messageResource->print("success","password berhasil diganti", 200);
            } else {
                return $messageResource->print("error", "token tidak valid", 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return $messageResource->print("error", "gagal mengupdate password", 404);

        }
        
    }
}
