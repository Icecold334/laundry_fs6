@extends('layout.admin.main')
@section('content')
<h1>Daftar Pengguna yang Sudah Dihapus</h1>

<div class="table-responsive">
    <table class="table" id="trashedUsers">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">#</th>
                <th class="text-center">Nama</th>
                <th class="text-center" style="width: 15%">Username</th>
                <th class="text-center" style="width: 15%">Nomor Telepon</th>
                <th class="text-center">Email</th>
                <th class="text-center" style="width: 20%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trashedUsers as $user)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td class="text-center">{{ $user->phone }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">
                    <form action="{{ route('user.restore', $user->id) }}" method="POST" class="d-inline">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-success">
        <i class="fas fa-undo"></i> Pulihkan
    </button>
</form>
<form action="{{ route('user.force', $user->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
        <i class="fas fa-trash-alt"></i> Hapus Permanen
    </button>
</form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
