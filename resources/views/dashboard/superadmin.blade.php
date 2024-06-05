@extends('layout.admin.main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-gray-800">Dashboard</h1>

        <form action="{{ url('/panel') }}" method="GET" class="d-flex">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <label for="date" class="col-form-label">Select Date:</label>
                    <div class="input-group">
                        @php
                            $currentDate = \Carbon\Carbon::now()->toDateString();
                        @endphp
                        <input type="date" class="form-control" id="date" name="date" value="{{ request()->input('date', $currentDate) }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" style="font-style: italic;">Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="row">
        <!-- Pesanan Masuk -->
        <div class="col-lg-3 mb-3">
            <div class="card text-white bg-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pesanan Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-bag fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Selesai -->
        <div class="col-lg-3 mb-3">
            <div class="card text-white bg-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pesanan Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{ $completedOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pendapatan -->
        <div class="col-lg-3 mb-3">
            <div class="card text-white bg-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-white">
                                {{ $totalRevenue }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pelanggan -->
        <div class="col-lg-3 mb-3">
            <div class="card text-white bg-purple shadow h-100 py-2" style="background-color: #6f42c1;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Total Kariyawan</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Diagram garis -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Analisa Pesanan</h6>
                </div>
                <div class="card-body">
                    <canvas id="ordersLineChart" width="100" height="200"></canvas>
                </div>
            </div>
        </div>
        <!-- Diagram lingkaran -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pesanan</h6>
                </div>
                <div class="card-body">
                    <canvas id="ordersPieChart" width="100" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Diagram baris
            var ctxLine = document.getElementById('ordersLineChart').getContext('2d');
            var ordersLineChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Orders',
                        data: @json($ordersPerMonth),
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : null;
                                },
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
    
            // Diagram lingkaran
            var ctxPie = document.getElementById('ordersPieChart').getContext('2d');
            var ordersPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Dibuat', 'Pembayaran', 'Diproses', 'Siap Diambil'],
                    datasets: [{
                        data: [
                            {{ $orderStatus[0] }},
                            {{ $orderStatus[1] }},
                            {{ $orderStatus[2] }},
                            {{ $orderStatus[3] }},
                        ],
                        backgroundColor: [
                            '#6c757d', 
                            '#ffc107', 
                            '#17a2b8', 
                            '#007bff',  
                        ],
                        hoverBackgroundColor: [
                            '#6c757d', 
                            '#ffc107', 
                            '#17a2b8', 
                            '#007bff',  
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 10,
                                boxWidth: 10,
                            }
                        },
                    },
                }
            });
        });
    </script>
    @endsection