<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products;
use App\Http\Requests\StoreOrdersRequest;
use App\Http\Requests\UpdateOrdersRequest;
use Illuminate\Support\Facades\Http;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Pesanan',
            'orders' => Orders::orderBy('created_at', 'desc')->get()
        ];
        return view('orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // create a new resource
        $data = [
            'title' => 'Pesanan',
            'products' => Products::all(),
        ];
        return view('orders.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrdersRequest $request)
    {
        $prov = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' . $request->provinsi . '.json')->body();
        dd($prov);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrdersRequest $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        //
    }
}