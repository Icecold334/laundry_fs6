@extends('layout.admin.main')
@section('content')
    <h1 class="mb-3">Laporan</h1>
    <div class="accordion mb-3" id="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button
                    class="accordion-button {{ request()->user || request()->product || request()->status || request()->from || request()->to ? '' : 'collapsed' }}"
                    type="button" data-bs-toggle="collapse" data-bs-target="#filter" aria-expanded="false"
                    aria-controls="filter">
                    <h5 class="mb-0 font-weight-bolder text-black-50">Cari Berdasarkan</h5>
                </button>
            </h2>

            <div id="filter"
                class="accordion-collapse collapse {{ request()->user || request()->product || request()->status || request()->from || request()->to ? 'show' : '' }}"
                data-bs-parent="#accordion">
                <div class="accordion-body">

                    <form action="">
                        <div class="row">
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-3">
                                <div class="form-group mb-3">

                                    <select class="custom-select  @error('user') is-invalid @enderror"
                                        aria-label="Pilih Layanan" id="user" name="user">
                                        <option value=""></option>

                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @selected($user->id == request()->user)>
                                                {{ ucfirst($user->name) }}</option>
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
                                    <select class="custom-select @error('product') is-invalid @enderror"
                                        aria-label="Pilih Layanan" id="product" name="product">
                                        <option value=""></option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" @selected($product->id == request()->product)>
                                                {{ $product->name }}</option>
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
                                    <select class="custom-select @error('status') is-invalid @enderror"
                                        aria-label="Pilih Status" id="status" name="status">
                                        <option value=""></option>
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
                            <div class="col-xl-3 col-md-6 col-sm-12 mb-3"><input type="text" class="form-control"
                                    value="{{ Carbon\Carbon::parse(request()->from)->format('m/d/Y') }} - {{ Carbon\Carbon::parse(request()->to)->format('m/d/Y') }}"
                                    id="date" />
                                <input type="hidden" value="{{ request()->from ?? '' }}" name="from" id="from">
                                <input type="hidden" value="{{ request()->to ?? '' }}" name="to" id="to">
                            </div>
                            @push('scripts')
                                <script>
                                    $('#date').daterangepicker({
                                        opens: 'left'
                                    }, function(start, end, label) {
                                        $('#from').val(start.format('YYYY-MM-DD'))
                                        $('#to').val(end.format('YYYY-MM-DD'))
                                    });
                                </script>
                            @endpush
                            <div class="col-xl-3 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-4 col-md-4 col-sm-4 mb-3"><button
                                            class="btn btn-primary btn-block"><i class="fa-solid fa-filter"></i></button>
                                    </div>
                                    <div class="col-xl-4 col-md-4 col-sm-4 mb-3"><a href="/report"
                                            class="btn btn-primary btn-block"><i class="fa-solid fa-rotate-left"></i></a>
                                    </div>
                                    @if ($orders->count() > 0)
                                        <div class="col-xl-4 col-md-4 col-sm-4 mb-3"><a
                                                href="/report/export?user={{ request()->user }}&product={{ request()->product }}&status={{ request()->status }}&from={{ request()->from }}&to={{ request()->to }}"
                                                class="btn btn-primary btn-block"><i
                                                    class="fa-solid fa-file-export"></i></a>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </form>

                    @push('scripts')
                        <script>
                            $('#user').select2({
                                allowClear: true,
                                theme: "bootstrap-5",
                                placeholder: 'Pilih Pengguna'
                            });
                            $('#product').select2({
                                allowClear: true,
                                theme: "bootstrap-5",
                                placeholder: 'Pilih Layanan'
                            });
                            $('#status').select2({
                                allowClear: true,
                                theme: "bootstrap-5",
                                placeholder: 'Pilih Status'
                            });
                        </script>
                    @endpush
                </div>
            </div>
        </div>

    </div>

    <div class="row pl-3">
        <div class="col-xl-5">
            <div class="row mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pengguna</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ ucfirst($user_name) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-user fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Jumlah Pesanan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-people-carry-box fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Jumlah Pemasukan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ 'Rp ' . number_format($orders->sum('total'), 2, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-money-bill fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            @if ($orders->count() > 0)
                <div class="card" style="max-height: 25rem;overflow-y: auto;">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" style="width: 5%">#</th>
                                <th scope="col" style="width: 15%">Layanan</th>
                                <th scope="col" style="width: 10%">Jumlah</th>
                                <th scope="col" style="width: 15%">Total</th>
                                <th scope="col" style="width: 10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $order->product->name }}</td>
                                    <td class="{{ $order->quantity ? 'text-right' : 'text-center' }}">
                                        {{ $order->quantity ? $order->quantity . ' Kg' : '-' }} </td>
                                    <td class="text-right">
                                        {{ $order->total ? 'Rp ' . number_format($order->total, 2, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        @switch($order->status)
                                            @case(0)
                                                <span class="badge bg-secondary text-white">Pesanan Dibuat</span>
                                            @break

                                            @case(1)
                                                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                            @break

                                            @case(2)
                                                <span class="badge bg-info text-white">Pesanan Diproses</span>
                                            @break

                                            @case(3)
                                                <span class="badge bg-primary text-white">Pesanan Siap Diambil</span>
                                            @break

                                            @case(4)
                                                <span class="badge bg-success text-white">Pesanan Selesai</span>
                                            @break
                                        @endswitch
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-danger text-center" role="alert">
                    Tidak Ada Pesanan
                </div>
            @endif
        </div>
        <script></script>
    </div>
@endsection
