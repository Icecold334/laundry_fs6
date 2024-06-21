@extends('layout.admin.main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
    </div>

    <div class="row">
        <!-- Pesanan Masuk -->
        <div class="col-xl-3 col-md-3 col-sm-12 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Pesanan Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pendapatan -->
        <div class="col-xl-3 col-md-3 col-sm-12 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRevenue }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Karyawan -->
        <div class="col-xl-3 col-md-3 col-sm-12 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Karyawan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmployee }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Pengguna -->
        <div class="col-xl-3 col-md-3 col-sm-12 col-md-6 mb-4">
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
    <div class="row">
        @if ($totalOrders > 0)
            <!-- Diagram -->
            <div class="col-xl-6 col-md-12 col-sm-12 mb-4">
                <!-- Status Pesanan -->
                <div class="card shadow mb-4" style="height: 20rem">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Pesanan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersPieChart" width="100" height="260"></canvas>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-xl-{{ $totalOrders > 0 ? '6' : '12' }} col-md-12 col-sm-12 mb-4">
            <!-- Status Pesanan -->
            <div class="card shadow mb-4" style="height: 20rem">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Analisa Pesanan</h6>
                </div>
                <div class="card-body">
                    <canvas id="ordersLineChart" width="100" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Diagram baris
                var ctxLine = document.getElementById('ordersLineChart').getContext('2d');
                var ordersLineChart = new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: ['Jan', '', 'Mar', '', 'Mei', '', 'Juli', '', 'Sep', '', 'Nov', ''],
                        datasets: [{
                            label: 'Orders',
                            data: @json($ordersPerMonth),
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.1)',
                            fill: true,
                            tension: 0.4
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
            });
        </script>
        @if ($totalOrders > 0)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Diagram lingkaran
                    var ctxPie = document.getElementById('ordersPieChart').getContext('2d');
                    var ordersPieChart = new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: ['Dibuat', 'Pembayaran', 'Diproses', 'Siap Diambil', 'Selesai'],
                            datasets: [{
                                data: [
                                    {{ $orderStatus[0] }},
                                    {{ $orderStatus[1] }},
                                    {{ $orderStatus[2] }},
                                    {{ $orderStatus[3] }},
                                    {{ $orderStatus[4] }},
                                ],
                                backgroundColor: [
                                    '#6c757d',
                                    '#ffc107',
                                    '#17a2b8',
                                    '#007bff',
                                    '#1cc88a ',
                                ],
                                hoverBackgroundColor: [
                                    '#6c757d',
                                    '#ffc107',
                                    '#17a2b8',
                                    '#007bff',
                                    '#1cc88a ',
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
        @endif
    @endpush
@endsection
