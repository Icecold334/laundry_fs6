@extends('layout.admin.main')
@section('content')
    <h1><a href="/products"><i class="fa-solid fa-chevron-left"></i></a> Detail Layanan</h1>
    <div class="row">
        <div class="col-xl-6 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Layanan</h4>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Nama Layanan</th>
                                <td style="width: 5%;">:</td>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Durasi</th>
                                <td>:</td>
                                <td>{{ $product->duration }} Hari</td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>:</td>
                                <td>{{ 'Rp ' . number_format($product->price, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>:</td>
                                <td>{{ $product->description }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
