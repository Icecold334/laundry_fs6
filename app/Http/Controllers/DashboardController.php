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
        // Tanggal
        $selectedDate = $request->input('date');

        if ($selectedDate) {
            $startDate = Carbon::parse($selectedDate)->startOfMonth();
            $endDate = Carbon::parse($selectedDate)->endOfMonth();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        // Total Orders
        $totalOrders = Orders::whereBetween('created_at', [$startDate, $endDate])->count();
        $completedOrders = Orders::where('status', 4)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Total Pendapatan
        if ($startDate->month != $endDate->month) {
            $totalRevenue = 0;
        } else {
            $totalRevenue = Orders::selectRaw('SUM(total) as total_revenue')
                ->where('status', 4)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->first()
                ->total_revenue;
        }

        // Total Kariyawan
        $totalEmployee = User::where('role', 2)->count();

        // Total Pengguna
        $totalUsers = User::where('role', 3)->count();

        // Analisa Pesanan
        $statuses = [0, 1, 2, 3];
        $orderStatus = [];

        foreach ($statuses as $status) {
            $orderStatus[$status] = Orders::where('status', $status)->count();
        }

        // Status Pesanan
        $ordersPerMonth = Orders::selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
            ->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $ordersPerMonthData = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $ordersPerMonthData[$i] = $ordersPerMonth[$month] ?? 0;
        }

        // Data
        $data = [
            'title' => 'Dashboard',
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'totalUsers' => $totalUsers,
            'totalEmployee' => $totalEmployee,
            'orderStatus' => $orderStatus,
            'ordersPerMonth' => array_values($ordersPerMonthData),
            'totalRevenue' => 'Rp ' . number_format($totalRevenue, 0, ',', ','),
        ];

        return view('dashboard.index', $data);
    }
}
