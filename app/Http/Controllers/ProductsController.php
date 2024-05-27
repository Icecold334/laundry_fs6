<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Layanan',
            'products' => Products::orderBy('price', 'asc')->get()
        ];
        return view('products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Products $product)
    {
        if ($request->user()->cannot('create', $product)) {
            abort(403);
        }
        // create a new resource
        $data = [
            'title' => 'Layanan',
        ];
        return view('products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request, Products $product)
    {
        // validation
        if ($request->user()->cannot('create', $product)) {
            abort(403);
        }
        $credentials = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string'],
            'duration' => ['required', 'numeric', 'max:15'],
        ]);

        if ($credentials->fails()) {
            return back()->with('error', 'Tambah Layanan Gagal!')->withErrors($credentials)->onlyInput('name', 'price', 'duration', 'description');
        }
        // store the resource
        $product = new Products();
        $product->name = $request->name;
        $product->code = strtoupper(substr($request->name, 0, 3));
        $product->price = str_replace('.', '', $request->price);
        $product->description = $request->description;
        $product->duration = $request->duration;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Tambah Layanan Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
        // show the product
        $data = [
            'title' => 'Layanan',
            'product' => $product
        ];
        return view('products.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Products $product)
    {
        if ($request->user()->cannot('update', $product)) {
            abort(403);
        }
        // edit the product
        $data = [
            'title' => 'Layanan',
            'product' => $product
        ];
        return view('products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Products $product)
    {
        if ($request->user()->cannot('update', $product)) {
            abort(403);
        }
        // validation
        $credentials = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string'],
            'duration' => ['required', 'numeric', 'max:15'],
        ]);

        if ($credentials->fails()) {
            return back()->with('error', 'Ubah Data Layanan Gagal!')->withErrors($credentials)->onlyInput('name', 'price', 'duration', 'description');
        }
        // update the product
        $product->name = $request->name;
        $product->code = strtoupper(substr($request->name, 0, 3));
        $product->price = str_replace('.', '', $request->price);
        $product->duration = $request->duration;
        $product->description = $request->description;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Ubah Layanan Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Products $product)
    {
        if ($request->user()->cannot('delete', $product)) {
            abort(403);
        }
        // delete product
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Hapus Layanan Berhasil!');
    }
}
