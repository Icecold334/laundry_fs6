@extends('layout.admin.main')
@section('content')
    <h1>Daftar Layanan <a href="/products/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a></h1>
    <table class="table" id="products">
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
                    <td>{{ 'Rp ' . number_format($product->price, 2, ',', '.') }}</td>
                    <td class="text-right ">{{ $product->duration }} Hari</td>
                    <td class="text-center">
                        <a href="/products/{{ $product->id }}" class="btn badge bg-info text-white px-1">
                            <i class="fa-solid fa-circle-info"></i>
                        </a>
                        <a href="/products/{{ $product->id }}/edit" class="btn badge bg-warning text-white px-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form class="d-inline" action="/products/{{ $product->id }}" method="POST"
                            id="formDel{{ $product->id }}">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button class="btn badge bg-danger text-white px-1" id="delete{{ $product->id }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @push('scripts')
                            <script>
                                $('#delete{{ $product->id }}').click(() => {
                                    Swal.fire({
                                        title: "Apa Kamu Yakin?",
                                        text: "Yakin Hapus Layanan {{ $product->name }}?",
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        cancelButtonColor: "#d33",
                                        confirmButtonText: "Ya",
                                        cancelButtonText: "Tidak"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            let form = $('#formDel{{ $product->id }}')
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
    @push('scripts')
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
