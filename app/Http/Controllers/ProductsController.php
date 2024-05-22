<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'products' => Products::all(),
            'user' => Auth::user(),
            'title' => 'Produk'
        ];
        return view('products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Produk',
            'user' => Auth::user()
        ];
        return view('products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        
        Products::create(['name' => $name, 'price' => $price, 'description' => $description]);
        
        return redirect()->route('products.index')->with('success', "Produk $name berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products, $id)
    {
        $data = [
            'title' => $products->all()->find($id)->name,
            'data' => $products->all()->find($id),
        ];
        return view('products.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products, $id)
    {
        $data = [
            'data' => $products->all()->find($id),
            'title' => 'Produk',
            'user' => Auth::user()
        ];
        return view('products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Products $products, $id)
    {
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        
        $product = Products::find($id);
        $product->update(['name' => $name, 'price' => $price, 'description' => $description]);
        
        return redirect()->route('products.index')->with('success', "Produk $name berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products, $id)
    {
        $name = $products->find($id)->name;
        $products->destroy($id);
        return redirect()->route('products.index')->with('success', "Produk $name berhasil dihapus");
    }

    public function check(Request $request)
    {
        $form = $request->keys()[0];
        $args = $form == 'name' ? 'required' : 'required|integer';
        $validate = $request->validate([
            $form => $args
        ]);
        return response()->json(['success' => true]);
    }
}
