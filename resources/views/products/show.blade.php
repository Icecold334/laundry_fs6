@extends('layout.admin.main')
@section('content')
    <h1><a href="/products"><i class="fa-solid fa-chevron-left"></i></a> Detail Layanan</h1>
    <div class="row">
        <div class="col-xl-6 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Layanan {{ $product->name }}</h4>
                        <h5 class="card-title">{{ $product->duration }} Hari</h5>
                    </div>
                    <h6 class="text-right card-subtitle mb-2 text-body-secondary">
                        {{ 'Rp ' . number_format($product->price, 2, ',', '.') }}
                    </h6>
                    <div class="card-text">
                        <h5>
                            {{ $product->description }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
