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
                                <tr>
                                    <th style="width:  50%">Pengiriman Awal</th>
                                    <th style="width: 5%">:</th>
                                    <th style="width: 30%">{{ $order->before == 0 ? 'Diantar' : 'Diambil' }}</th>
                                </tr>
                                <tr>
                                    <th style="width:  50%">Pengiriman Akhir</th>
                                    <th style="width: 5%">:</th>
                                    <th style="width: 30%">{{ $order->after == 0 ? 'Diambil' : 'Diantar' }}</th>
                                </tr>
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
                                                <textarea class="form-control @error('review') is-invalid @enderror" rows="3" name="review">{{ old('review') }}</textarea>
                                                @error('review')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
                                @can('update', [App\Models\Orders::class, $order])
                                    @if (
                                        !($order->status == 1 && $order->method == 1) &&
                                            $order->status != 3 &&
                                            $order->status != 4 &&
                                            Auth::user()->role != 3)
                                        <tr>
                                            <th colspan="3">
                                                <a href="/orders/{{ $order->code }}/edit"
                                                    class="btn btn-warning btn-block text-dark">Proses
                                                    Pesanan</a>
                                            </th>
                                        </tr>
                                    @endif
                                @endcan
                                @if ($order->status == 1 && $order->method == 1 && $order->user_id == Auth::user()->id)
                                    <tr>
                                        <th colspan="3">
                                            <button id="pay{{ $order->id }}" class="btn btn-success btn-block">Bayar
                                                Pesanan</button>
                                        </th>
                                        @push('scripts')
                                            <script>
                                                $('#pay{{ $order->id }}').click(() => {
                                                    Swal.fire({
                                                        title: "Tunggu Sebentar",
                                                        showConfirmButton: false,
                                                        allowEscapeKey: false,
                                                        allowOutsideClick: false
                                                    });
                                                    Swal.showLoading(Swal.getDenyButton());
                                                    // ajax with post method
                                                    $.ajax({
                                                        url: '/midtrans/pay',
                                                        type: 'GET',
                                                        data: {
                                                            total: {{ $order->total }},
                                                            item_details: JSON.stringify({
                                                                id: '{{ $order->code }}',
                                                                price: {{ $order->product->price }},
                                                                quantity: Math.floor({{ $order->quantity }}),
                                                                name: 'Paket {{ $order->product->name }}',
                                                            }),
                                                            name: '{{ $order->user->name }}',
                                                            email: '{{ $order->user->email }}',
                                                            phone: '{{ $order->user->phone }}',
                                                        },
                                                        success: function(data) {
                                                            snap.pay(data, {
                                                                onSuccess: function(result) {
                                                                    window.location.href =
                                                                        "/midtrans/success/{{ $order->id }}"; // Redirect to callback URL
                                                                },
                                                                onClose: function(result) {
                                                                    var Toast = Swal.mixin({
                                                                        toast: true,
                                                                        position: "top-start",
                                                                        showConfirmButton: false,
                                                                        timer: 3000,
                                                                        timerProgressBar: true,
                                                                        didOpen: (toast) => {
                                                                            toast.onmouseenter = Swal.stopTimer;
                                                                            toast.onmouseleave = Swal.resumeTimer;
                                                                        }
                                                                    });
                                                                    Toast.fire({
                                                                        showCloseButton: true,
                                                                        icon: "error",
                                                                        title: "Pembayaran gagal!"
                                                                    });
                                                                },
                                                                onPending: function(result) {
                                                                    var Toast = Swal.mixin({
                                                                        toast: true,
                                                                        position: "top-start",
                                                                        showConfirmButton: false,
                                                                        timer: 3000,
                                                                        timerProgressBar: true,
                                                                        didOpen: (toast) => {
                                                                            toast.onmouseenter = Swal.stopTimer;
                                                                            toast.onmouseleave = Swal.resumeTimer;
                                                                        }
                                                                    });
                                                                    Toast.fire({
                                                                        showCloseButton: true,
                                                                        icon: "error",
                                                                        title: "Pembayaran gagal!"
                                                                    });
                                                                },
                                                                onError: function(result) {
                                                                    window.location.href = "/midtrans/error";
                                                                }
                                                            });
                                                            Swal.close();
                                                        },
                                                    });


                                                });
                                            </script>
                                        @endpush
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
