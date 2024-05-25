@extends('layout.admin.main')
@section('content')
    <h1><a href="/people"><i class="fa-solid fa-chevron-left"></i></a> Data Karyawan {{ $user->name }}</h1>
    <div class="row">
        <div class="col-xl-6 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $user->name }}</h4>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Karyawan</h6>
                    <div class="card-text">
                        <table>
                            <tr>
                                <td colspan="3"><img src="{{ asset('storage/people/' . $user->img) }}" alt=""
                                        class="img-thumbnail"></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
