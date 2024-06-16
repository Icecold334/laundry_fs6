@extends('layout.admin.main')
@section('content')
    <h1><a href="/orders"><i class="fa-solid fa-chevron-left"></i></a> Pesanan Milik {{ $order->user->name }}</h1>
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
                                <tr>
                                    <th style="width:  50%">Metode Pembayaran</th>
                                    <th style="width: 5%">:</th>
                                    <th style="width: 30%">{{ $order->method ? 'Non-Tunai' : 'Tunai' }}</th>
                                </tr>
                                @if ($order->before == 1 || $order->after == 1)
                                    <tr>
                                        <th style="width:  50%">Alamat</th>
                                        <th style="width: 5%">:</th>
                                        <th style="width: 30%">{{ $order->address }}</th>
                                    </tr>
                                @endif
                                @if ($order->status !== 0)
                                    <form action="/orders/{{ $order->code }}" method="POST" id="status">
                                        @csrf
                                        @method('PUT')
                                    </form>
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
                                @endif
                                @if ($order->status == 0)
                                    <form action="/orders/{{ $order->code }}" method="POST" id="status">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" value="1" name="status">
                                        <tr>
                                            <th style="width:  50%">Jumlah Pesanan</th>
                                            <th style="width: 5%">:</th>
                                            <th style="width: 30%">
                                                <div class="input-group">
                                                    <input value="{{ old('quantity') }}" type="text"
                                                        class="form-control @error('quantity') is-invalid @enderror"
                                                        name="quantity" id="quantity">
                                                    @error('quantity')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <span class="input-group-text">Kg</span>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width:  50%">Total Bayar</th>
                                            <th style="width: 5%">:</th>
                                            <th style="width: 30%">
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input value="{{ old('total') ?? 0 }}" type="text"
                                                        class="form-control @error('total') is-invalid @enderror"
                                                        name="total" id="total" readonly>
                                                </div>
                                            </th>
                                        </tr>
                                    </form>
                                @endif
                                <tr>
                                    <th colspan="3">
                                        <div class="d-grid gap-2">
                                            <button id="next"
                                                class="btn btn-primary btn-block  @if ($order->status == 0 && $order->method == 0) disabled @endif">
                                                Lanjutkan Pesanan Ke Tahap Selanjutnya
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#quantity').keyup((e) => {
                let quantity = mustNumeric($('#quantity').val());
                $('#quantity').val(quantity);
                if (quantity > 0) {
                    $('#next').removeClass('disabled');
                } else {
                    $('#next').addClass('disabled');
                }
                let total = quantity.replace(',', '.') * {{ $order->product->price ?? 0 }};
                $('#total').val(rupiah(`${total}`));
            });

            $('#next').click(() => {
                Swal.fire({
                    title: "Apa Kamu Yakin?",
                    html: "Yakin Melanjutkan Pesanan <b>{{ $order->code }}</b>?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = $('#status')
                        form.submit();
                    }
                });
            })
        </script>
    @endpush
@endsection
