@extends('layout.admin.main')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2><a href="/products"><i class="fa-solid fa-chevron-left"></i></a> Data Layanan {{ $data->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Description: </strong> {{ $data->description }}</p>
            <p><strong>Price: </strong>Rp {{ $data->price }}</p>
        </div>
    </div>
@endsection
