@extends('layout.admin.main')
@section('content')
    <h1><a href="/products"><i class="fa-solid fa-chevron-left"></i></a> Sampah Layanan
    </h1>
    @csrf
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
                        <td class="text-right">{{ $product->duration }} Hari</td>
                        <td class="text-center">
                            <a href="/products/{{ $product->id }}" class="btn badge bg-info text-white px-1">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            @can('restore', [App\Models\Products::class, $product])
                                <button id="restore{{ $product->id }}" class="btn badge bg-warning text-white px-1">
                                    <i class="fa-solid fa-recycle"></i>
                                </button>
                                @push('scripts')
                                    <script>
                                        document.getElementById('restore{{ $product->id }}').addEventListener('click', function() {
                                            Swal.fire({
                                                title: "Apa Kamu Yakin?",
                                                html: "Yakin Memulihkan Layanan <b>{{ $product->name }}</b>?",
                                                icon: "question",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Ya",
                                                cancelButtonText: "Tidak"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "/products/{{ $product->id }}/restore";
                                                }
                                            });
                                        });
                                    </script>
                                @endpush
                            @endcan
                            @can('forceDelete', [App\Models\Products::class, $product])
                                <form class="d-inline" action="/products/{{ $product->id }}/force" method="POST"
                                    id="formDel{{ $product->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button class="btn badge bg-danger text-white px-1" id="delete{{ $product->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                @push('scripts')
                                    <script>
                                        document.getElementById('delete{{ $product->id }}').addEventListener('click', function() {
                                            Swal.fire({
                                                title: "Apa Kamu Yakin?",
                                                html: "Yakin Hapus Permanen Layanan <b>{{ $product->name }}</b>?",
                                                icon: "question",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Ya",
                                                cancelButtonText: "Tidak"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('formDel{{ $product->id }}').submit();
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
