@extends('layout.admin.main')
@section('content')
    <h1>Recycle Bin</h1>
    <div class="table-responsive">
        <table class="table" id="recycle">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th class="text-center">Produk</th>
                    <th class="text-center" style="width: 15%">Harga</th>
                    <th class="text-center" style="width: 10%">Durasi</th>
                    <th class="text-center" style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ 'Rp ' . number_format($product->price, 2, ',', '.') }}/Kg</td>
                        <td class="text-right ">{{ $product->duration }} Hari</td>
                        <td class="text-center">
                            @can('superadmin')
                                <form class="d-inline" action="/products/{{ $product->id }}/restore" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn badge bg-success text-white px-1" type="submit">
                                        <i class="fa-solid fa-trash-restore"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @push('scripts')
        <script>
            $("#recycle").DataTable({
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
