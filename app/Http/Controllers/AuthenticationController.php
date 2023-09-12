<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlamatRequest;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Resources\RoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\AlamatResource;
use App\Http\Resources\UserResource;
use App\Message\MessageResource;
use App\Models\alamat;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    //
    public function login(StoreLoginRequest $request, )
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Akun tidak ditemukan'],
            ]);
        }
        if ($user->role->nama_role != 'customer') {
            throw ValidationException::withMessages([
                'email' => ['unauthorize'],
            ]);
        } else {
            $token = $user->createToken('User Login')->plainTextToken;
            return $token;
        }
        
    }

    public function loginAdmin(StoreLoginRequest $request, )
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Akun tidak ditemukan'],
            ]);
        }
        if ($user->role->nama_role == 'customer') {
            throw ValidationException::withMessages([
                'email' => ['unauthorize'],
            ]);
        } else {
            $token = $user->createToken('User Login')->plainTextToken;
            return $token;
        }
        
    }

    public function register(StoreRegisterRequest $request, User $user, StoreAlamatRequest $storeAlamatRequest, MessageResource $messageResource)
    {
      try {
        DB::beginTransaction();
        $user = User::create($request->getData());
        if ($user->role_id != 3) {
            $addAlamat = $user->alamat()->create($storeAlamatRequest->validated());
        }
        DB::commit();
        return $messageResource->print("success", "berhasil mendaftar", 200);
        
      } catch (\Throwable $th) {
        return $messageResource->print("success", $th, 400);
        DB::rollBack();
      }
        // $user = User::create($request->getData());
        // $addAlamat = $user->alamat()->create($storeAlamatRequest->validated());
        // return response()->json(["data"=>"Berhasil Mendaftar"]);
    }

    public function logout(Request $request, MessageResource $messageResource)
    {
        $request->user()->currentAccessToken()->delete();
        return $messageResource->print("success", "berhasil logout", 200);

    }
}