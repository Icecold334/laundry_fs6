@extends('layout.admin.main')
@section('content')
    <h1>
        Daftar Karyawan
        <a href="/people/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
        @if (\App\Models\User::onlyTrashed()->where('role', 2)->count() > 0)
            <a href="/people/trash" class="btn btn-warning text-dark"><i class="fa-solid fa-recycle"></i> Sampah</a>
        @endif
    </h1>
    @csrf
    <div class="table-responsive">
        <table class="table" id="products">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center" style="width: 15%">Username</th>
                    <th class="text-center" style="width: 15%">Nomor Telepon</th>
                    <th class="text-center">Email</th>
                    <th class="text-center" style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td class="text-center">{{ $user->phone }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            <a href="/people/{{ $user->id }}" class="btn badge bg-info text-white px-1">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            <a href="/people/{{ $user->id }}/edit" class="btn badge bg-warning text-white px-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form class="d-inline" action="/people/{{ $user->id }}" method="POST"
                                id="formDel{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button class="btn badge bg-danger text-white px-1" id="delete{{ $user->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @push('scripts')
                                <script>
                                    $('#delete{{ $user->id }}').click(() => {
                                        Swal.fire({
                                            title: "Apa Kamu Yakin?",
                                            text: "Yakin Hapus Karyawan {{ $user->name }}?",
                                            icon: "question",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Ya",
                                            cancelButtonText: "Tidak"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                let form = $('#formDel{{ $user->id }}')
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
                var Toast = Swal.mixin({
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
                    targets: 5
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
