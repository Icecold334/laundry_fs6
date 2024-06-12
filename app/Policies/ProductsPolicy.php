<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Products;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProductsPolicy
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
    public function view(User $user, Products $products): bool
    {
        return $products->trashed()
            ? $products->role == 1
            : $user->id == $products->user_id || $user->role!== 3;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Products $products): bool
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Products $products): bool
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, $products): bool
    {
        return $user->role == 1 && $products->count() > 0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Products $products): bool
    {
        return $user->role == 1;
    }
}
