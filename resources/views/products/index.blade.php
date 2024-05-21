@extends('layout.admin.main')
@section('content')
    <h1>Daftar Layanan <a href="/products/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a></h1>
    <table class="table" id="products">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">#</th>
                <th class="text-center">Produk</th>
                <th class="text-center" style="width: 20%">Harga</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    @push('scripts')
        <script>
            $("#products").DataTable({
                columnDefs: [{
                    orderable: false,
                    targets: 3
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
