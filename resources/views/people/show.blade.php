@extends('layout.admin.main')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><a href="/people"><i class="fa-solid fa-chevron-left"></i></a> Data Karyawan {{ $user->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Username: </strong> {{ $user->username }}</p>
        </div>
    </div>
@endsection
