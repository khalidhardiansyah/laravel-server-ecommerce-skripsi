<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Role;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransaksiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Transaksi $transaksi)
    {
        return $user->id == $transaksi->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {return $user->role->nama_role == 'customer';

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Transaksi $transaksi)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Transaksi $transaksi)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Transaksi $transaksi)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Transaksi $transaksi)
    {
        //
    }
}
