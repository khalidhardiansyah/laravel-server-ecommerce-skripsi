<?php

namespace App\Http\Controllers;

use App\Http\Requests\sendLinkResetPasswordRequest;
use App\Mail\SendEmail;
use App\Message\MessageResource;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendLinkResetPasswordControlller extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(sendLinkResetPasswordRequest $request, MessageResource $messageResource)
{
    $email = $request->validated(); // Peroleh email dari array hasil validasi
    $user = User::where('email', $email)->first();
    $shop_url = env('SHOP_URL');
    if ($user) {
        $token = Str::random(64);
        // $resetPassword = PasswordReset::where('email', $email)->first();
            $reset = PasswordReset::create([
                'email' => $user->email,
                'token' => $token,
            ]);
      
        $data = [
            "name" => $user->name,
            "email"=>$user->email,
            "token" =>$reset->token,
            "link"=>$shop_url.'/reset-password/'.$reset->token
        ];
        Mail::to($email)->send(new SendEmail($data));
        return $messageResource->print("success", "Reset password telah dikirm ke email anda", 200);
    } else {
        return $messageResource->print("error", "User tidak ditemukan", 404);
    }
}

}
