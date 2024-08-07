<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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
        $statuses = [0, 1, 2, 3, 4];
        $orderStatus = [];

        foreach ($statuses as $status) {
            $orderStatus[$status] = Orders::where('status', $status)
                ->whereDate('created_at', $today)
                ->count();
        }
        // Status Pesanan
        $ordersPerMonth = Orders::selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
            ->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck(
                'count',
                'month'
            )
            ->toArray();

        $ordersPerMonthData = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $ordersPerMonthData[$i] = $ordersPerMonth[$month] ?? 0;
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
            'ordersPerMonth' => array_values($ordersPerMonthData),
            'orderStatus' => $orderStatus,
            'totalRevenue' => 'Rp ' . number_format($totalRevenue, 0, ',', ','),
        ];
        return view('dashboard.index', $data);
    }
}
