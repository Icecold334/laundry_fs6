@extends('layout.admin.main')
@section('content')
    <h1>Daftar Layanan <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a></h1>
    <table class="table" id="products">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">#</th>
                <th class="text-center">Layanan</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center" style="width: 20%">Harga</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-center">{{ $product->description }}</td>
                    <td class="text-center">Rp {{ $product->price }}</td>
                    <td class="text-center">
                        <a href="{{ route('products.show', $product->id) }}" class="btn badge bg-info text-white px-1">
                            <i class="fa-solid fa-circle-info"></i>
                        </a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn badge bg-warning text-white px-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn badge bg-danger text-white px-1" onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
        function confirmDelete(id) {
            Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
                });
            }
            });
        }
    </script>
@endsection
