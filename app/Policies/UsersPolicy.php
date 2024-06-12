<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UsersPolicy
    {
        public function view(User $user, ): bool
        {
            return $user->trashed()
                ? $user->role == 1
                : true;
        }

        public function restore(User $user, User $model)
        {

            // Add your logic here to check if the user can be restored
            return $user->hasRole('superadmin');// Example
        }

        public function forceDelete(User $user, User $model)
        {
            // Add your logic here to check if the user can be permanently deleted
            return $user->hasRole('superadmin');// Example
        }

    }
