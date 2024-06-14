@extends('layout.admin.main')
@section('content')
    <h1><a href="{{ $order->trashed() ? '/orders/trash' : '/orders' }}"><i class="fa-solid fa-chevron-left"></i></a> Detail
        Pesanan</h1>
    <div class="row">
        <div class="col-xl-6 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title font-weight-bold">Nomor Pesanan</h5>
                        <h5 class="card-title font-weight-bold">{{ $order->code }}</h5>
                    </div>
                    <div class="card-text">
                        <table class="table">
                            <thead>
                                @if (Auth::user()->role !== 3)
                                    <tr>
                                        <th style="width:  50%">Nama Pengguna</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ $order->user->name ?? '-' }}</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th style="width:  50%">Jenis Layanan</th>
                                    <th style="width: 5%">:</th>
                                    <th style="width: 30%">{{ $order->product->name ?? '-' }}</th>
                                </tr>
                                <tr>
                                    <th style="width:  50%">Status</th>
                                    <th style="width: 5%">:</th>
                                    <th style="width: 30%">
                                        @switch($order->status)
                                            @case(0)
                                                <span class="badge bg-secondary text-white">Pesanan Dibuat</span>
                                            @break

                                            @case(1)
                                                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                            @break

                                            @case(2)
                                                <span class="badge bg-info text-white">Pesanan Diproses</span>
                                            @break

                                            @case(3)
                                                <span class="badge bg-primary text-white">Pesanan Siap Diambil</span>
                                            @break

                                            @case(4)
                                                <span class="badge bg-success text-white">Pesanan Selesai</span>
                                            @break
                                        @endswitch
                                    </th>
                                </tr>
                                @if ($order->status > 0 && Auth::user()->role != 3)
                                    <tr>
                                        <th style="width:  50%">Penanggung Jawab</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">
                                            {{ $order->staff->name ?? \App\Models\User::find(1)->name }}</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th style="width:  50%">Metode Pembayaran</th>
                                    <th style="width: 5%">:</th>
                                    <th style="width: 30%">{{ $order->method ? 'Non-Tunai' : 'Tunai' }}</th>
                                </tr>
                                @if ($order->status !== 0)
                                    <tr>
                                        <th style="width:  50%">Jumlah Pesanan</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ $order->quantity }} Kg</th>
                                    </tr>
                                    <tr>
                                        <th style="width:  50%">Total Bayar</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ 'Rp ' . number_format($order->total, 2, ',', '.') }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="width:  50%">Tanggal Masuk</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ $date }}</th>
                                    </tr>
                                @endif
                                @if ($order->before == 1 || $order->after == 1)
                                    <tr>
                                        <th style="width:  50%">Alamat</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ $order->address }}</th>
                                    </tr>
                                @endif
                                @if ($order->status == 3 && Auth::user()->id == $order->user_id)
                                    <form action="/orders/{{ $order->code }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <tr>
                                            <th style="width:  50%">Ulasan</th>
                                            <th style="width: 5%">:</th>
                                            <th style="width: 30%">
                                                <textarea class="form-control" rows="3" name="review"></textarea>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">
                                                <div class="d-grid gap-2">
                                                    <button id="next" class="btn btn-success btn-block">
                                                        Pesanan Selesai
                                                    </button>
                                                </div>
                                            </th>
                                        </tr>
                                    </form>
                                @endif
                                @if ($order->status == 4)
                                    <tr>
                                        <th style="width:  50%">Ulasan</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">
                                            {{ $order->review }}
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
