<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerServiceUpdateByManajer;
use App\Http\Requests\selfUpdatePasswordRequest;
use App\Http\Requests\StoreAlamatRequest;
use App\Http\Requests\StoreCustomerServiceRequest;
use App\Http\Requests\UserSelfUpdatedRequest;
use App\Http\Resources\UserResource;
use App\Message\MessageResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public function createCS(StoreCustomerServiceRequest $request, MessageResource $messageResource)
    {
        $this->authorize('create', $request->user());
        User::create($request->getData());
       return $messageResource->print("success_cs","akun customer service berhasil dibuat",201);
    }

    public function selfUpdateProfile(UserSelfUpdatedRequest $request, MessageResource $messageResource, Request $alamatrequest)
{
    $this->authorize('update', $request->user());
    $role = $request->user()->role->nama_role;

    if ($role === "customer") {
        try {
            //  $storeAlamatRequest = new StoreAlamatRequest();
            DB::beginTransaction();
            $user = User::find($request->user()->id);
            $user->update($request->validated());
            $user->alamat()->update([
                'alamat_detail' => $request->alamat_detail,
                'kode_pos' => $request->kode_pos,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
            ]);            
            DB::commit();
            return $messageResource->print("success_update_customer", "Akun berhasil diperbarui", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $messageResource->print("error_update_customer", "Akun gagal diperbarui", 400);
        }
    } else {
        try {
            DB::beginTransaction();
            $user = User::find($request->user()->id);
        $user->update($request->validated());
        DB::commit();
        return $messageResource->print("success_update_admin", "Akun berhasil diperbarui", 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $messageResource->print("error_update_admin", $th, 400);
        }
    }
}


    public function selfUpdatePassword(selfUpdatePasswordRequest $request, User $user ,MessageResource $messageResource){
        $this->authorize('update', $request->user());
        $user = User::find($request->user()->id);
        $user->update($request->getData());
        return $messageResource->print("success_password","Password berhasil diperbarui",201);
    }

    public function userUpdate(CustomerServiceUpdateByManajer $request, $id, User $user,  MessageResource $messageResource)
    {
       $this->authorize('manajerUpdate', $request->user());
        $user = $user->find($id);
        $user->update($request->getData());
        return $messageResource->print("success","Akun berhasil diperbarui",200);
    }

    public function userCustomer(){
        $user = User::whereHas('role', function($query){
            $query->where('nama_role', 'customer');
        })->get();
        return UserResource::collection($user);
    }

    public function userCustomerService(){
        $user = User::whereHas('role', function(Builder $query){
            $query->where('nama_role', 'customer service');
        })->get();
        return UserResource::collection($user);
    }

    
    public function deleteUser($id, User $user, MessageResource $messageResource, Request $request)
    {
        // $this->authorize('delete', $request->user());
        $result = $user->find($id);
         $result->delete();
        return $messageResource->print("success", "Berhasil dihapus",204);
    }


    
}
