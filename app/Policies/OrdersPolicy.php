<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Orders;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class OrdersPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, $order): bool
    {
        return $user->id == $order->user_id || $user->role !== 3;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 3;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, $order): bool
    {

        return $user->role != 3 && $order->status != 4 && !($order->status == 1 && $order->method == 1);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Orders $orders): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Orders $orders): bool
    {
        //
    }
}
