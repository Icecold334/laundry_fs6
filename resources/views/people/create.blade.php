@extends('layout.admin.main')
@section('content')
    <h1><a href="/people"><i class="fa-solid fa-chevron-left"></i></a> Tambah Karyawan </h1>
    <div class="row">
        <div class="col-xl-8 col-md-10 col-sm-12">
            <form action="/people" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                    <input value="{{ old('name') }}" type="text"
                        class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
                    <input value="{{ old('username') }}" type="text"
                        class="form-control @error('username') is-invalid @enderror" name="username" id="username">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number<span class="text-danger">*</span></label>
                    <input value="{{ old('phone') }}" type="number"
                        class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                    <input value="{{ old('email') }}" type="text"
                        class="form-control @error('email') is-invalid @enderror" name="email" id="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
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
        </script>
    @endpush
@endsection
