@extends('layout.admin.main')
@section('content')
    <h1><a href="/people"><i class="fa-solid fa-chevron-left"></i></a> Sampah Karyawan</h1>
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
                            @can('restore', [App\Models\User::class, $user])
                                <button id="restore{{ $user->id }}" class="btn badge bg-warning text-white px-1">
                                    <i class="fa-solid fa-recycle"></i>
                                </button>
                                @push('scripts')
                                    <script>
                                        $('#restore{{ $user->id }}').click(() => {
                                            Swal.fire({
                                                title: "Apa Kamu Yakin?",
                                                html: "Yakin Memulihkan Karyawan <b>{{ $user->name }}</b>?",
                                                icon: "question",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Ya",
                                                cancelButtonText: "Tidak"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: '{{ route('people.restore', $user->id) }}',
                                                        type: 'PUT',
                                                        data: {
                                                            '_token': '{{ csrf_token() }}'
                                                        },
                                                        success: () => {
                                                            location.reload();
                                                        }
                                                    });
                                                }
                                            });
                                        });
                                    </script>
                                @endpush
                            @endcan
                            <button id="force{{ $user->id }}" class="btn badge bg-danger text-white px-1">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                            @push('scripts')
                                <script>
                                    $('#force{{ $user->id }}').click(() => {
                                        Swal.fire({
                                            title: "Apa Kamu Yakin?",
                                            html: "Yakin Menghapus Karyawan <b>{{ $user->name }}</b>?",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Ya",
                                            cancelButtonText: "Tidak"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $.ajax({
                                                    url: '{{ route('people.force', $user->id) }}',
                                                    type: 'DELETE',
                                                    data: {
                                                        '_token': '{{ csrf_token() }}'
                                                    },
                                                    success: () => {
                                                        location.reload();
                                                    }
                                                });
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
@endsection