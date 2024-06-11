@extends('layout.admin.main')
@section('content')
    <h1><a href="/orders"><i class="fa-solid fa-chevron-left"></i></a> Buat Pesanan </h1>
    <div class="row">
        <div class="col-xl-8 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="/orders" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="product" class="form-label">Pilih Layanan<span
                                            class="text-danger">*</span></label>
                                    <select class="custom-select @error('product') is-invalid @enderror"
                                        aria-label="Pilih Layanan" id="product" name="product">
                                        <option value="">Pilih Layanan</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" @selected($product->id == old('product'))>
                                                {{ $product->name }} -
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
                                    <select class="custom-select  @error('method') is-invalid @enderror"
                                        aria-label="Pilih Layanan" id="method" name="method">
                                        <option value="">Pilih Metode</option>
                                        <option value="0" @selected('0' == old('method'))>Tunai</option>
                                        <option value="1" @selected('1' == old('method'))>Non-Tunai</option>
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
                                    <label for="before" class="form-label">Pengiriman Awal<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select class="custom-select @error('before') is-invalid @enderror"
                                        aria-label="Pengiriman Awal" id="before" name="before">
                                        <option value="">Pilih Pengiriman</option>
                                        <option value="0" @selected('0' == old('before') || '0' == old('method'))>Diantar</option>
                                        <option value="1" @selected('1' == old('before'))>Diambil</option>

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
                                    <select class="custom-select @error('after') is-invalid @enderror"
                                        aria-label="Pengiriman Akhir" id="after" name="after">
                                        <option value="">Pilih Pengiriman</option>
                                        <option value="0" @selected('0' == old('after'))>Diambil</option>
                                        <option value="1" @selected('1' == old('after'))>Diantar</option>

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
                            <div class="col-xl-12 col-md-12 col-sm-12" id="form-address">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="3"
                                        placeholder="Tambahkan Nama Jalan, Gedung atau No. Rumah">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div id="after" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="note" rows="3" placeholder="Silahkan Tinggalkan Pesan" name="note">{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @if ((old('before') == null || old('before') == '0') && old('after') == '0')
            <script>
                $('#form-address').hide();
            </script>
        @endif
        <script>
            let before = 0;
            let after = 0;
            let method = parseInt($('#method').val());
            if (method == 0) {
                $('#before').val('0');
                $('#before').attr('disabled', true);
            } else {
                $('#before').attr('disabled', false);
            }

            function provShow(before = 0, after = 0) {
                if (before || after) {

                    return $('#form-address').fadeIn();

                } else {

                    return $('#form-address').fadeOut();
                }
            }
            $('#before').change(() => {
                before = parseInt($('#before').val());
                after = parseInt($('#after').val());
                provShow(before, after)
            });
            $('#after').change(() => {
                before = parseInt($('#before').val());
                after = parseInt($('#after').val());
                provShow(before, after);
            });
            $('#method').change(() => {
                let method = parseInt($('#method').val());
                after = parseInt($('#after').val());
                if (method == 0) {
                    $('#before').val('0');
                    $('#before').attr('disabled', true);
                } else {
                    $('#before').attr('disabled', false);
                }
                if (method == 0 && after == 0) {
                    $('#form-address').fadeOut();
                }
            });
        </script>
    @endpush
@endsection
