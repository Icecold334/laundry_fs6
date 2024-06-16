@extends('layout.admin.main')
@section('content')
    <h1><a href="/orders"><i class="fa-solid fa-chevron-left"></i></a> Sampah Pesanan
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
                        <td class="text-center">{{ $order->user->name ?? '-' }}</td>
                        <td class="text-center">{{ $order->product->name ?? '-' }}</td>
                        <td class="{{ $order->quantity ? 'text-right' : 'text-center' }}">
                            {{ $order->quantity ? $order->quantity . ' Kg' : '-' }} </td>
                        <td class="{{ $order->total ? 'text-right' : 'text-center' }}">
                            {{ $order->total ? 'Rp ' . number_format($order->total, 2, ',', '.') : '-' }}
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
                            <a href="/orders/{{ $order->code }}" class="btn badge bg-info text-white px-1">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            @can('restore', [App\Models\Orders::class, $order])
                                <button id="restore{{ $order->code }}" class="btn badge bg-warning text-white px-1">
                                    <i class="fa-solid fa-recycle"></i>
                                </button>
                                @push('scripts')
                                    <script>
                                        $('#restore{{ $order->code }}').click(() => {
                                            Swal.fire({
                                                title: "Apa Kamu Yakin?",
                                                html: "Yakin Memulihkan Pesanan <b>{{ $order->code }}</b>?",
                                                icon: "question",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Ya",
                                                cancelButtonText: "Tidak"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "/orders/restore/{{ $order->code }}";
                                                }
                                            });
                                        })
                                    </script>
                                @endpush
                            @endcan
                            <form class="d-inline" action="/orders/force/{{ $order->code }}" method="POST"
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
                                            html: "Yakin Hapus Permanen Pesanan <b>{{ $order->code }}</b>?",
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @push('scripts')
        @if (session('success'))
            <script>
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
                    icon: "success",
                    title: "{{ session('success') }}"
                });
            </script>
        @endif
        @if (session('error'))
            <script>
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
