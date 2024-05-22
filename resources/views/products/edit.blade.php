@extends('layout.admin.main')
@section('content')
    <h1><a href="/products"><i class="fa-solid fa-chevron-left"></i></a> Edit Layanan {{ $data->name }} </h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('products.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Layanan</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $data->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $data->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $data->price) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
