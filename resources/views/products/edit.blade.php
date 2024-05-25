@extends('layout.admin.main')
@section('content')
    <h1><a href="/people"><i class="fa-solid fa-chevron-left"></i></a> Ubah Data Layanan {{ $product->name }}</h1>
    <div class="row">
        <div class="col-xl-8 col-md-10 col-sm-12">
            <form action="/products/{{ $product->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Layanan<span class="text-danger">*</span></label>
                            <input value="{{ old('name') ?? $product->name }}" type="text"
                                class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga (/Kg)<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input value="{{ old('price') ?? $product->price }}" type="text"
                                    class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                                    placeholder="">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Durasi<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input value="{{ old('duration') ?? $product->duration }}" type="text"
                                    class="form-control @error('duration') is-invalid @enderror" name="duration"
                                    id="duration">
                                <span class="input-group-text">Hari</span>
                                @error('duration')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" rows="4" name="description">{{ $product->description }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#name').keyup((e) => {
                let name = $('#name').val();
                let username = name.split(' ');
                username = username.length > 1 ? username[0] + '_' + username[1] : username[0];
                $('#username').val(username.toLowerCase());
            });
            $('#price').keyup((e) => {
                let price = rupiah($('#price').val());
                $('#price').val(price);
            });
            $('#price').val(rupiah($('#price').val()));
            $('#duration').keyup((e) => {
                let duration = mustNumeric($('#duration').val());
                $('#duration').val(duration);
            })
        </script>
    @endpush
@endsection
