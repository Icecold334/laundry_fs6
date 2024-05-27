<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreOrdersRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateOrdersRequest;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Auth::user()->role == 3
            ? Orders::with(['product', 'user'])->where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get()
            : Orders::with(['product', 'user'])->orderBy('created_at', 'desc')->get();
        $data = [
            'title' => 'Pesanan',
            'orders' => $orders
        ];
        return view('orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Orders::class);
        $regencies = User::find(1);
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
        Gate::authorize('create', Orders::class);
        $addressRule = $request->before == 1 || $request->after == 1 ? ['required'] : [];
        // create a new resource
        $credentials = Validator::make($request->all(), [
            'product' => ['required'],
            'method' => ['required'],
            'before' => ['required'],
            'after' => ['required'],
            'kecamatan' => $addressRule,
            'kelurahan' => $addressRule,
        ]);
        if ($credentials->fails()) {
            return redirect()->back()->with('error', 'Tambah Pesanan Gagal!')->withErrors($credentials)->onlyInput('product', 'method', 'before', 'after', 'kecamatan', 'kelurahan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $order)
    {
        $order ?? abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        Gate::authorize('update', $orders);
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
