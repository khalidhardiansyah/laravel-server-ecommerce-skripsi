<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class tokenCheckController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            $personalAccessToken = PersonalAccessToken::findToken($token);

            if ($personalAccessToken) {
                $expirationSeconds = config('sanctum.expiration') * 60;
                $expiresAt = Carbon::parse($personalAccessToken->created_at)->addSeconds($expirationSeconds);

                if ($expiresAt->isPast()) {
                    // Token expired
                    return response()->json(false, 200);
                }

                // Token is valid
                return response()->json(true, 200);
            }
        }

        // No token provided
        return response()->json(false, 200);
    }
}
