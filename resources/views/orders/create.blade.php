@extends('layout.admin.main')
@section('content')
    <h1><a href="/orders"><i class="fa-solid fa-chevron-left"></i></a> Buat Pesanan </h1>
    <div class="row">
        <div class="col-xl-8 col-md-12 col-sm-12">
            <form action="/orders" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="product" class="form-label">Pilih Layanan<span class="text-danger">*</span></label>
                            <select class="custom-select @error('product') is-invalid @enderror" aria-label="Pilih Layanan"
                                id="product" name="product">
                                <option>Pilih Layanan</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @selected($product->id == old('product'))>{{ $product->name }} -
                                        {{ 'Rp ' . number_format($product->price, 2, ',', '.') }}/Kg</option>
                                @endforeach
                            </select>
                            @error('product')
                                <div id="product" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="method" class="form-label">Pilih Metode Pembayaran<span
                                    class="text-danger">*</span></label>
                            <select class="custom-select @error('method') is-invalid @enderror" aria-label="Pilih Layanan"
                                id="method" name="method">
                                <option>Pilih Metode</option>
                                <option value="0">Tunai</option>
                                <option value="1">Non-Tunai</option>
                            </select>
                            @error('method')
                                <div id="method" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group mb-3 ">
                            <label for="before" class="form-label">Pengiriman Awal<span class="text-danger">*</span>
                            </label>
                            <select class="custom-select @error('before') is-invalid @enderror" aria-label="Pengiriman Awal"
                                id="before" name="before">
                                <option>Pilih Pengiriman</option>
                                <option value="0">Diantar</option>
                                <option value="1">Diambil</option>

                            </select>
                            @error('before')
                                <div id="before" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm 12">
                        <div class="form-group mb-3 ">
                            <label for="after" class="form-label">Pengiriman Akhir<span
                                    class="text-danger">*</span></label>
                            <select class="custom-select @error('after') is-invalid @enderror" aria-label="Pengiriman Akhir"
                                id="after" name="after">
                                <option>Pilih Pengiriman</option>
                                <option value="0">Diambil</option>
                                <option value="1">Diantar</option>

                            </select>
                            @error('after')
                                <div id="after" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group mb-3" id="form-prov">
                            <label for="provinsi" class="form-label">Pilih Provinsi<span
                                    class="text-danger">*</span></label>
                            <select class="custom-select @error('provinsi') is-invalid @enderror"
                                aria-label="Pilih Provinsi" id="provinsi" name="provinsi">
                                <option>Pilih Provinsi</option>
                            </select>
                            @error('provinsi')
                                <div id="provinsi" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm-12">
                        <div class="form-group mb-3" id="form-kota">
                            <label for="kota" class="form-label">Pilih Kota/Kabupaten<span
                                    class="text-danger">*</span></label>
                            <select class="custom-select @error('kota') is-invalid @enderror"
                                aria-label="Pilih Kota/Kabupaten" id="kota" name="kota">
                                <option>Pilih Kota/Kabupaten</option>
                            </select>
                            @error('kota')
                                <div id="kota" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm 12">
                        <div class="form-group mb-3" id="form-kecamatan">
                            <label for="kecamatan" class="form-label">Pilih Kecamatan<span
                                    class="text-danger">*</span></label>
                            <select class="custom-select @error('kecamatan') is-invalid @enderror"
                                aria-label="Pilih Kecamatan" id="kecamatan" name="kecamatan">
                                <option>Pilih Kecamatan</option>
                            </select>
                            @error('kecamatan')
                                <div id="kecamatan" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm 12">
                        <div class="form-group mb-3" id="form-kelurahan">
                            <label for="kelurahan" class="form-label">Pilih Kelurahan<span
                                    class="text-danger">*</span></label>
                            <select class="custom-select @error('kelurahan') is-invalid @enderror"
                                aria-label="Pilih kelurahan" id="kelurahan" name="kelurahan">
                                <option>Pilih Kelurahan</option>
                            </select>
                            @error('kelurahan')
                                <div id="kelurahan" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12" id="form-address">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Tambahan</label>
                            <textarea class="form-control" id="address" rows="3" placeholder="Nama Jalan, Gedung atau No. Rumah"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea class="form-control" id="note" rows="3" placeholder="Silahkan Tinggalkan Pesan"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>

    </div>
    @push('scripts')
        <script>
            $('#form-prov').hide();
            $('#form-kota').hide();
            $('#form-kecamatan').hide();
            $('#form-kelurahan').hide();
            $('#form-address').hide();
            $.getJSON('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', (data) => {
                let options = '';
                $.each(data, (key, value) => {
                    options += `<option value="${value.id}">${value.name}</option>`;
                });
                $('#provinsi').append(options);
            });
            $('#provinsi').change(() => {
                let id = $('#provinsi').val();
                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`, (data) => {
                    let options = '<option ">Pilih Kota/Kabupaten</option>';
                    $.each(data, (key, value) => {
                        options += `<option value="${value.id}">${value.name}</option>`;
                    });
                    $('#kota').html(options);
                    $('#form-kota').fadeIn();
                });
            });
            $('#kota').change(() => {
                let id = $('#kota').val();
                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`, (data) => {
                    let options = '<option ">Pilih Kecamatan</option>';
                    $.each(data, (key, value) => {
                        options += `<option value="${value.id}">${value.name}</option>`;
                    });
                    $('#kecamatan').html(options);
                    $('#form-kecamatan').fadeIn();
                });
            });
            $('#kecamatan').change(() => {
                let id = $('#kecamatan').val();
                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`, (data) => {
                    let options = '<option ">Pilih Kelurahan</option>';
                    $.each(data, (key, value) => {
                        options += `<option value="${value.id}">${value.name}</option>`;
                    });
                    $('#kelurahan').html(options);
                    $('#form-kelurahan').fadeIn();
                });
            });
            $('#kelurahan').change(() => {
                $('#form-address').fadeIn();
            });


            let before = 0;
            let after = 0;

            function provShow(before = 0, after = 0) {
                if (before || after) {
                    return $('#form-prov').fadeIn();
                } else {
                    $('#form-prov').fadeOut();
                    $('#form-kota').fadeOut();
                    $('#form-kecamatan').fadeOut();
                    $('#form-kelurahan').fadeOut();
                    return $('#form-address').fadeOut();
                }
            }
            $('#before').change(() => {
                before = parseInt($('#before').val());
                provShow(before, after)
            });
            $('#after').change(() => {
                after = parseInt($('#after').val());
                provShow(before, after);
            });
            $('#method').change(() => {
                let method = parseInt($('#method').val());
                if (!method) {
                    $('#before').val('0');
                    $('#before').attr('disabled', true);
                    $('#form-prov').fadeOut();
                    $('#form-kota').fadeOut();
                    $('#form-kecamatan').fadeOut();
                    $('#form-kelurahan').fadeOut();
                    $('#form-address').fadeOut();

                } else {
                    $('#before').attr('disabled', false);
                }
            });
        </script>
    @endpush
@endsection
