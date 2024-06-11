@extends('layout.admin.main')
@section('content')
    <h1>Halaman Profil</h1>
    <div class="row">
        <div class="col-xl-6 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title font-weight-bold">{{ $user->code }}</h5>
                    </div>
                    <div class="card-text">
                        <table class="table">
                            <tr>
                                <th colspan="3">
                                    <div class="row justify-content-center">
                                        <div class="col-6"><img src="{{ asset('storage/people/' . $user->img) }}"
                                                alt="Foto Profil" class="img-thumbnail"></div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <th>:</th>
                                <th>{{ $user->name }}</th>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <th>:</th>
                                <th>{{ $user->username }}</th>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <th>:</th>
                                <th>{{ $user->phone }}</th>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th>:</th>
                                <th>{{ $user->email }}</th>
                            </tr>
                        </table>
                        <a href="profile/edit" class="btn btn-primary">Edit Profil</a>
                        <a href="profile/password" class="btn btn-outline-primary">Ubah Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
