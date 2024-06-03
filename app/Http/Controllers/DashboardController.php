<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total Orders
        $totalOrders = Orders::count();
        $completedOrders = Orders::where('status', 4)->count();

        // Total Pengguna
        $totalUsers = User::where('role', 3)->count();

        // Circle Status Diagram
        $statuses = [0, 1, 2, 3];
        $orderStatus = [];

        foreach ($statuses as $status) {
            $orderStatus[$status] = Orders::where('status', $status)->count();
        }

        // Data
        $data = [
            'title' => 'Dashboard',
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'totalUsers' => $totalUsers,
            'orderStatus' => $orderStatus,
        ];

        return view('dashboard.index', $data);
    }
}
