@extends('layout.admin.main')
@section('content')
    <h1><a href="/orders"><i class="fa-solid fa-chevron-left"></i></a> Detail Pesanan</h1>
    <div class="row">
        <div class="col-xl-6 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Nomor Pesanan</h4>
                        <h5 class="card-title font-weight-bold">{{ $order->code }}</h5>
                    </div>
                    <h6 class="text-right card-subtitle mb-2 text-body-secondary">
                        {{ $order->total ? 'Rp ' . number_format($order->total, 2, ',', '.') : '' }}
                    </h6>
                    <div class="card-text">

                        <table class="table">
                            <thead>
                                @if (Auth::user()->role !== 3)
                                    <tr>
                                        <th>Nama Pengguna</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ $order->user->name }}</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Jenis Layanan</th>
                                    <th style="width: 5%">:</th>
                                    <th style="width: 30%">{{ $order->product->name }}</th>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <th style="width: 5%">:</th>
                                    <th style="width: 30%">{{ $order->method ? 'Non-Tunai' : 'Tunai' }}</th>
                                </tr>
                                @if ($order->status !== 0)
                                    <tr>
                                        <th>Jumlah Pesanan</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ $order->quantity }} Kg</th>
                                    </tr>
                                    <tr>
                                        <th>Total Bayar</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ 'Rp ' . number_format($order->total, 2, ',', '.') }}
                                        </th>
                                    </tr>
                                @endif
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
