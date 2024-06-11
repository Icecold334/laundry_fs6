@extends('layout.admin.main')
@section('content')
    <h1><a href="/profile"><i class="fa-solid fa-chevron-left"></i></a> Ubah Profil </h1>
    <div class="row">
        <div class="col-xl-8 col-md-12 col-sm-12">
            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="name">Nama<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') ?? $user->name }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username') ?? $user->username }}">
                            @error('username')
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
                            <label for="phone">Nomor Telepon<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone') ?? $user->phone }}">
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') ?? $user->email }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <img id="imagePreview" src="{{ asset('storage/people') . '/' . $user->img }}" alt="Image Preview"
                            class="img-thumbnail mb-3" width="50%">
                        @push('scripts')
                            <script>
                                $(document).ready(function() {
                                    // Function to preview image after validation
                                    $(document).on('change', '#img', function() {
                                        var uploadField = $(this)[0];
                                        if (uploadField.files && uploadField.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                $('#imagePreview').attr('src', e.target.result);
                                            }

                                            // Validate file type
                                            var fileType = uploadField.files[0].type;
                                            if (fileType.startsWith('image/')) {
                                                reader.readAsDataURL(uploadField.files[0]);
                                                $('#imagePreview').removeClass('d-none')
                                            } else {
                                                Swal.fire({
                                                    title: "Gagal!",
                                                    text: "Masukkan File Gambar!",
                                                    icon: "error"
                                                });
                                                $('#imagePreview').attr('src', '#');
                                                $('#imagePreview').addClass('d-none')

                                            }
                                        }
                                    });
                                });
                            </script>
                        @endpush
                        <div class="form-group">
                            <label for="img">Foto Profil</label>
                            <input type="file" class="form-control @error('img') is-invalid @enderror" id="img"
                                name="img">
                            @error('img')
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
