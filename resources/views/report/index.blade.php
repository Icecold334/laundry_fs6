@extends('layout.admin.main')
@section('content')
    <h1 class="mb-3">Laporan</h1>
    <form action="">
        <div class="row">
            <div class="col-xl-2 col-md-6 col-sm-12 mb-3">
                <div class="form-group mb-3">
                    <select class="custom-select  @error('user') is-invalid @enderror" aria-label="Pilih Layanan"
                        id="user" name="user">
                        <option value=""></option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected($user->id == request()->user)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user')
                        <div id="user" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-xl-2 col-md-6 col-sm-12 mb-3">
                <div class="form-group mb-3">
                    <select class="custom-select @error('product') is-invalid @enderror" aria-label="Pilih Layanan"
                        id="product" name="product">
                        <option value=""></option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected($product->id == request()->product)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product')
                        <div id="product" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-xl-2 col-md-6 col-sm-12 mb-3">
                <div class="form-group mb-3">
                    <select class="custom-select @error('status') is-invalid @enderror" aria-label="Pilih Status"
                        id="status" name="status">
                        <option value=""></option>
                        <option value="0" @selected('0' == request()->status)>Pesanan Dibuat</option>
                        <option value="1" @selected('1' == request()->status)>Menunggu Pembayaran</option>
                        <option value="2" @selected('2' == request()->status)>Pesanan Diproses</option>
                        <option value="3" @selected('3' == request()->status)>Pesanan Siap Diambil</option>
                        <option value="4" @selected('4' == request()->status)>Pesanan Selesai</option>
                    </select>
                    @error('status')
                        <div id="status" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-xl-2 col-md-6 col-sm-12 mb-3"><input type="text" class="form-control" id="date" />
                <input type="hidden" value="" name="from" id="from">
                <input type="hidden" value="" name="to" id="to">
            </div>
            @push('scripts')
                <script>
                    $('#date').daterangepicker({
                        opens: 'left'
                    }, function(start, end, label) {
                        $('#from').val(start.format('YYYY-MM-DD'))
                        $('#to').val(end.format('YYYY-MM-DD'))
                        // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
                        //     'YYYY-MM-DD'));
                    });
                </script>
            @endpush
            <div class="col-xl-2 col-md-6 col-sm-12 mb-3">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-6 mb-3"><button class="btn btn-primary btn-block"><i
                                class="fa-solid fa-filter"></i></button></div>
                    <div class="col-xl-6 col-md-6 col-sm-6 mb-3"><a href="/report" class="btn btn-primary btn-block"><i
                                class="fa-solid fa-rotate-left"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            $('#user').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Pengguna'
            });
            $('#product').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Layanan'
            });
            $('#status').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Status'
            });
        </script>
    @endpush
@endsection
