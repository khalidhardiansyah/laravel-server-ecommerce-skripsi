<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Message\MessageResource;
use Illuminate\Http\Request;
use App\Models\Role;
class RoleController extends Controller
{
    //
    public function Index()
    {
        $role = Role::all();
        return RoleResource::collection($role);
    }

    public function store(Request $request, MessageResource $messageResource)
    {
        $role = new Role;
        $role->nama_role = $request->nama_role;
        $role->save();
        return $messageResource->print("success","role berhasil dibuat",201);
    }
    
}
