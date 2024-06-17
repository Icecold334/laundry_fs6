@extends('layout.admin.main')
@section('content')
    <h1>
        Daftar Pesanan
        @can('create', App\Models\Orders::class)
            <a href="/orders/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
        @endcan
        @can('restore', [App\Models\Orders::class, App\Models\Orders::onlyTrashed()])
            <a href="/orders/trash" class="btn btn-warning text-dark"><i class="fa-solid fa-recycle"></i> Sampah</a>
        @endcan
    </h1>
    @csrf
    <div class="table-responsive">
        <table class="table" id="orders">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th class="text-center" style="width: 10%">Nomor</th>
                    @if (Auth::user()->role !== 3)
                        <th class="text-center" style="width: 10%">Atas Nama</th>
                    @endif
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
                    <tr id="{{ $order->id }}">
                        <td class="text-center number">{{ $loop->iteration }}</td>
                        <td class="code">{{ $order->code }}</td>
                        @if (Auth::user()->role !== 3)
                            <td class="name">{{ $order->user->name ?? '-' }}</td>
                        @endif
                        <td class="product">{{ $order->product->name ?? '-' }}</td>
                        <td class="{{ $order->quantity ? 'text-right' : 'text-center' }} qty">
                            {{ $order->quantity ? $order->quantity . ' Kg' : '-' }} </td>
                        <td class="{{ $order->total ? 'text-right' : 'text-center' }} total">
                            {{ $order->total ? 'Rp ' . number_format($order->total, 2, ',', '.') : '-' }}
                        </td>
                        <td class="text-center status">
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
                        <td class="text-center method">{{ $order->method ? 'Non-Tunai' : 'Tunai' }} </td>
                        <td class="text-center pay">
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
                            @can('delete', [App\Models\Orders::class, $order])
                                <form class="d-inline" action="/orders/{{ $order->code }}" method="POST"
                                    id="formDel{{ $order->code }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button class="btn badge bg-danger text-white px-1" id="delete{{ $order->code }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                @push('scripts')
                                    <script>
                                        $('#delete{{ $order->code }}').click(() => {
                                            Swal.fire({
                                                title: "Apa Kamu Yakin?",
                                                html: "Yakin Hapus Pesanan <b>{{ $order->code }}</b>?",
                                                icon: "question",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Ya",
                                                cancelButtonText: "Tidak"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    let form = $('#formDel{{ $order->code }}')
                                                    form.submit();
                                                }
                                            });
                                        });
                                    </script>
                                @endpush
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @push('scripts')
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
                pageLength: 10,
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
