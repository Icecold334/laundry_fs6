@extends('layout.admin.main')
@section('content')
    <h1>
        Daftar Pesanan
        @can('create', App\Models\Orders::class)
            <a href="/orders/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
        @endcan
    </h1>
    @csrf
    <div class="table-responsive">
        <table class="table" id="orders">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th class="text-center" style="width: 10%">Nomor</th>
                    <th class="text-center" style="width: 10%">Atas Nama</th>
                    <th class="text-center" style="width: 15%">Layanan</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Pembayaran</th>
                    <th class="text-center" style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                @php
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $order->code }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td class="text-right">{{ $order->quantity ? $order->quantity . ' Kg' : '-' }} </td>
                        <td class="text-right">{{ $order->total ? 'Rp ' . number_format($order->total, 2, ',', '.') : '-' }}
                        </td>
                        <td class="text-center">
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
                        </td>
                        <td class="text-center">{{ $order->method ? 'Non-Tunai' : 'Tunai' }} </td>
                        <td class="text-center">
                            {{-- @if (Auth::user()->role !== 3 && $order->status == 1 && $order->method == 0)
                            <a href="#" class="btn badge bg-success text-white px-1">
                                <i class="fa-solid fa-money-bill"></i>
                            </a>
                        @endif --}}
                            @if (Auth::user()->role == 3 && $order->status == 1 && $order->method == 1)
                                <button id="pay{{ $order->id }}" class="btn badge bg-success text-white px-1">
                                    <i class="fa-solid fa-money-bill"></i>
                                </button>
                                @push('scripts')
                                    <script>
                                        $('#pay{{ $order->id }}').click(() => {
                                            Swal.fire({
                                                title: "Tunggu Sebentar",
                                                showConfirmButton: false,
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
                                                        onPending: function(result) {},
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
                            @endif
                            <a href="/orders/{{ $order->code }}" class="btn badge bg-info text-white px-1">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            @can('update', [App\Models\Orders::class, $order])
                                @if ($order->status !== 4 && ($order->status !== 1 || $order->method == 0))
                                    <a href="/orders/{{ $order->code }}/edit" class="btn badge bg-warning text-white px-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endif
                            @endcan
                            @can('delete', App\Models\Orders::class)
                                <form class="d-inline" action="/orders/{{ $order->code }}" method="POST"
                                    id="formDel{{ $order->code }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button class="btn badge bg-danger text-white px-1" id="delete{{ $order->code }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @push('scripts')
        @if (session('success'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "{{ session('success') }}"
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "{{ session('error') }}"
                });
            </script>
        @endif
        <script>
            $("#orders").DataTable({
                columnDefs: [{
                    orderable: false,
                    targets: 7
                }],
                paging: true,
                lengthMenu: [5, 10, 20, {
                    label: "Semua",
                    value: -1
                }],
                pageLength: 5,
                language: {
                    decimal: "",
                    searchPlaceholder: "Cari Data",
                    emptyTable: "Tabel kosong",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    infoPostFix: "",
                    thousands: ",",
                    lengthMenu: "Tampilkan _MENU_ data",
                    loadingRecords: "Loading...",
                    processing: "",
                    search: "Cari:",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        first: "<<",
                        last: ">>",
                        next: ">",
                        previous: "<",
                    },
                    aria: {
                        orderable: "Order by this column",
                        orderableReverse: "Reverse order this column",
                    },
                },
            });
            // set local storage
        </script>
    @endpush
@endsection
