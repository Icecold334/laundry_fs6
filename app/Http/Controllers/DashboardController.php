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

        // Hari ini
        $today = Carbon::today();

        // Total Orders
        $totalOrders = Orders::whereDate('created_at', $today)->count();
        $completedOrders = Orders::where('status', 4)
            ->whereDate('created_at', $today)
            ->count();

        // Total Pendapatan
        $totalRevenue = Orders::where('status', 4)
            ->whereDate('created_at', $today)
            ->sum('total');

        // Total Karyawan
        $totalEmployee = User::where('role', 2)->count();


        // Total Pengguna
        $totalUsers = User::where('role', 3)->count();

        // Analisa Pesanan
        $statuses = [0, 1, 2, 3];
        $orderStatus = [];

        foreach ($statuses as $status) {

            $orderStatus[$status] = Orders::where('status', $status)->count();

            $orderStatus[$status] = Orders::where('status', $status)
                ->whereDate('created_at', $today)
                ->count();

        }

        // Data
        $data = [
            'title' => 'Dashboard',
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'totalUsers' => $totalUsers,
            'totalEmployee' => $totalEmployee,
            'orderStatus' => $orderStatus,

            'totalRevenue' => 'Rp ' . number_format($totalRevenue, 0, ',', ','),

        ];

        return view('dashboard.index', $data);
    }
}
