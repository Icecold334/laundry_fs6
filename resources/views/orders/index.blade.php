@extends('layout.admin.main')
@section('content')
    <h1>Daftar Pesanan <a href="/orders/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a></h1>
    @csrf
    <table class="table" id="orders">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">#</th>
                <th class="text-center" style="width: 20%">Nomor Pesanan</th>
                <th class="text-center" style="width: 20%">Layanan</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center" style="width: 10%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders->where('user_id', '=', Auth::user()->id) as $order)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td class="text-right">{{ $order->quantity }} Kg</td>
                    <td class="text-right">{{ 'Rp ' . number_format($order->total, 2, ',', '.') }}</td>
                    <td class="text-center"><span class="badge bg-primary text-white">Pesanan Dibuat</span></td>
                    <td class="text-center">
                        <a href="/people/{{ $order->id }}" class="btn badge bg-info text-white px-1">
                            <i class="fa-solid fa-circle-info"></i>
                        </a>
                        <a href="/people/{{ $order->id }}/edit" class="btn badge bg-warning text-white px-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form class="d-inline" action="/people/{{ $order->id }}" method="POST"
                            id="formDel{{ $order->id }}">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button class="btn badge bg-danger text-white px-1" id="delete{{ $order->id }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
            $("#products").DataTable({
                columnDefs: [{
                    orderable: false,
                    targets: 4
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
        </script>
    @endpush
@endsection
