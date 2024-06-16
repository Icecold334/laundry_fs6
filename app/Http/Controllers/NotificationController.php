<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function delete($user_id, $id = 0)
    {
        if ($user_id == 0) {
            return Notification::where('id', $id)->delete();
        } else {
            return Notification::where('user_id', $user_id)->delete();
        }
    }
}
