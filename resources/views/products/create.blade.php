@extends('layout.admin.main')
@section('content')
    <h1><a href="/products"><i class="fa-solid fa-chevron-left"></i></a> Data Layanan </h1>
    <div class="row">
        <div class="col-xl-8 col-md-10 col-sm-12">
            <form action="/products" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="description" id="description">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Harga <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="price" id="price">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
