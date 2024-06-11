<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class OrdersPolicy
    {
        public function restore(User $user)
        {
            // Add your logic here to check if the user can be restored
            return true; // Example
        }

        public function forceDelete(User $user)
        {
            // Add your logic here to check if the user can be permanently deleted
            return true; // Example
        }

    }
