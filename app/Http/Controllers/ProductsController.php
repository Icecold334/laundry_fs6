<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;

class ProductsController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Layanan',
            'products' => Products::orderBy('price', 'asc')->get()
        ];

        return view('products.index', $data);
    }

    public function create(Request $request, Products $product)
    {
        Gate::authorize('create', $product);
        $data = [
            'title' => 'Layanan',
        ];
        return view('products.create', $data);
    }

    public function store(StoreProductsRequest $request, Products $product)
    {
        Gate::authorize('create', $product);

        $credentials = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'price' => ['required', 'string'],
            'duration' => ['required', 'numeric', 'max:15'],
        ], [
            'name.required' => 'Nama Layanan Wajib Diisi!',
            'name.string' => 'Nama Layanan Wajib Diisi!',
            'name.min' => 'Nama Layanan Minimal :min Karakter!',
            'price.required' => 'Harga Layanan Wajib Diisi!',
            'price.string' => 'Harga Layanan Wajib Diisi!',
            'duration.required' => 'Durasi Layanan Wajib Diisi!',
            'duration.numeric' => 'Durasi Layanan Wajib Diisi!',
            'duration.max:15' => 'Durasi Layanan Wajib Diisi!',
        ]);

        if ($credentials->fails()) {
            return back()->with('error', 'Tambah layanan gagal!')->withErrors($credentials)->onlyInput('name', 'price', 'duration', 'description');
        }

        $product = new Products();
        $product->name = $request->name;
        $product->code = strtoupper(substr($request->name, 0, 3));
        $product->price = str_replace('.', '', $request->price);
        $product->description = $request->description;
        $product->duration = $request->duration;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Tambah layanan berhasil!');
    }

    public function show(Products $product)
    {
        Gate::authorize('view', $product);

        $data = [
            'title' => 'Layanan',
            'product' => $product
        ];
        return view('products.show', $data);
    }


    public function edit(Request $request, Products $product)
    {
        Gate::authorize('create', $product);

        $data = [
            'title' => 'Layanan',
            'product' => $product
        ];
        return view('products.edit', $data);
    }

    public function update(UpdateProductsRequest $request, Products $product)
    {
        Gate::authorize('create', $product);

        $credentials = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string'],
            'duration' => ['required', 'numeric', 'max:15'],
        ], [
            'name.required' => 'Nama Layanan Wajib Diisi!',
            'name.string' => 'Nama Layanan Wajib Diisi!',
            'name.max:255' => 'Nama Layanan Wajib Diisi!',
            'price.required' => 'Harga Layanan Wajib Diisi!',
            'price.string' => 'Harga Layanan Wajib Diisi!',
            'duration.required' => 'Durasi Layanan Wajib Diisi!',
            'duration.numeric' => 'Durasi Layanan Wajib Diisi!',
            'duration.max:15' => 'Durasi Layanan Wajib Diisi!',
        ]);

        if ($credentials->fails()) {
            return back()->with('error', 'Ubah layanan gagal!')->withErrors($credentials)->onlyInput('name', 'price', 'duration', 'description');
        }

        $product->name = $request->name;
        $product->code = strtoupper(substr($request->name, 0, 3));
        $product->price = str_replace('.', '', $request->price);
        $product->duration = $request->duration;
        $product->description = $request->description;
        $product->update();
        return redirect()->route('products.index')->with('success', 'Ubah layanan berhasil!');
    }

    public function destroy(Request $request, Products $product)
    {
        Gate::authorize('delete', $product);
        if (Orders::where('product_id', $product->id)->where('status', '<', 4)->count() > 0) {
            return redirect()->route('products.index')->with('error', "Pesanan dengan layanan <b>$product->name</b> belum selesai!");
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Hapus Layanan Berhasil!');
    }

    public function force(Products $product)
    {
        $product->forceDelete();
        return redirect()->route(Products::onlyTrashed()->count() > 0 ? 'products.trash' : 'products.index')->with('success', 'Layanan berhasil dihapus!');
    }

    public function trash()
    {
        $trashedProducts = Products::onlyTrashed()->get();
        if ($trashedProducts->isEmpty()) {
            return redirect()->route('products.index');
        }

        $data = [
            'title' => 'Layanan',
            'products' => $trashedProducts
        ];

        return view('products.trash', $data);
    }

    public function restore(Products $product)
    {
        $product->restore();
        return redirect()->route(Products::onlyTrashed()->count() > 0 ? 'products.trash' : 'products.index')->with('success', 'Layanan berhasil dipulihkan!');
    }
}
