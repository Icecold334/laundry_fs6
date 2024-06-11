<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use Illuminate\Support\Facades\Gate;

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
            return back()->with('error', 'Tambah Layanan Gagal!')->withErrors($credentials)->onlyInput('name', 'price', 'duration', 'description');
        }

        $product = new Products();
        $product->name = $request->name;
        $product->code = strtoupper(substr($request->name, 0, 3));
        $product->price = str_replace('.', '', $request->price);
        $product->description = $request->description;
        $product->duration = $request->duration;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Tambah Layanan Berhasil!');
    }

    public function show(Products $product)
    {
        $product = Products::withTrashed()->findOrFail($id);
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
            return back()->with('error', 'Ubah Data Layanan Gagal!')->withErrors($credentials)->onlyInput('name', 'price', 'duration', 'description');
        }

        $product->name = $request->name;
        $product->code = strtoupper(substr($request->name, 0, 3));
        $product->price = str_replace('.', '', $request->price);
        $product->duration = $request->duration;
        $product->description = $request->description;
        $product->update();
        return redirect()->route('products.index')->with('success', 'Ubah Layanan Berhasil!');
    }

    public function destroy(Request $request, Products $product)
    {
        Gate::authorize('delete', $product);

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Hapus Layanan Berhasil!');
    }

    public function force($id)
    {
        $product = Products::withTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->route(Products::onlyTrashed()->count() > 0 ? 'products.trash' : 'products.index')->with('success', 'Layanan Berhasil Dihapus!');
    }

    public function trash()
    {
        $trashedProducts = Products::onlyTrashed()->get();
        if ($trashedProducts->isEmpty()) {
            return redirect()->route('products.index');
        }

        $data = [
            'title' => 'Layanan Terhapus',
            'products' => $trashedProducts
        ];

        return view('products.trash', $data);
    }

    public function restore($id)
    {
        $product = Products::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route(Products::onlyTrashed()->count() > 0 ? 'products.trash' : 'products.index')->with('success', 'Layanan Berhasil Dipulihkan!');
    }
}
