@extends('layout.admin.main')
@section('content')
    <h1><a href="/profile"><i class="fa-solid fa-chevron-left"></i></a> Ubah Password </h1>
    <div class="row">
        <div class="col-xl-8 col-md-8 col-sm-12">
            <form action="/profile/password" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="current_password">Password Lama<span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="password">Password Baru<span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru<span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
