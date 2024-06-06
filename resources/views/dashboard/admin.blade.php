@extends('layout.admin.main')

@section('content')
<h1 class="h2 text-gray-800">Dashboard</h1>
    <div class="row">
        <!-- pesanan masuk -->
        <div class="col-lg-6">
            <div class="row">
                <div class="col-xl-12 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pesanan Masuk</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- pesanan selesai -->
            <div class="row">
                <div class="col-xl-12 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Pesanan Selesai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedOrders }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- total pengguna -->
            <div class="row">
                <div class="col-xl-12 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Pengguna</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagram lingkaran -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pesanan</h6>
                </div>
                <div class="card-body">
                    <canvas id="ordersPieChart" width="100" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
