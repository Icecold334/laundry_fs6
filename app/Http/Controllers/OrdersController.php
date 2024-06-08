<?php

namespace App\Http\Controllers;


use App\Models\Orders;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreOrdersRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateOrdersRequest;
use App\Models\User;
use Carbon\Carbon;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Auth::user()->role == 3
            ? Orders::with(['product', 'user'])->where('user_id', '=', Auth::user()->id)->orderBy('status')->get()
            : Orders::with(['product', 'user'])->orderBy('status')->get();
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
            'address' => $addressRule,
        ], [
            'product.required' => 'Layanan tidak boleh kosong!',
            'method.required' => 'Pilih metode pembayaran!',
            'before.required' => 'Pilih pengiriman awal!',
            'after.required' => 'Pilih pengiriman akhir!',
            'address.required' => 'Alamat Tidak Boleh Kosong!',
        ]);
        if ($credentials->fails()) {
            return redirect()->back()->with('error', 'Tambah Pesanan Gagal!')->withErrors($credentials)->onlyInput('product', 'method', 'before', 'after', 'address', 'note');
        }
        // create a new order
        $order = new Orders();
        $order->code = Products::find($request->product)->code . sprintf("%06s", (int)substr(Orders::withTrashed()->where('code', 'like', Products::find($request->product)->code . '%')->get()->last()->code ?? 0, -6) + 1);
        $order->user_id = Auth::user()->id;
        $order->product_id = $request->product;
        $order->before = $request->before;
        $order->after = $request->after;
        $order->method = $request->method;
        $order->address = $request->address;
        $order->status = 0;
        $order->save();
        return redirect()->route('orders.index')->with('success', 'Pesanan Berhasil Dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $order)
    {
        Gate::authorize('view', $order);
        $order ?? abort(404);

        //tanggal
        $date = Carbon::parse($order->created_at)->locale('id')->translatedFormat('l, d-m-Y H:i');

        $data = [
            'title' => 'Pesanan',
            'order' => $order,
            'date' => $date,
        ];
        return view('orders.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $order)
    {
        Gate::authorize('update', $order);
        $order ?? abort(404);
        $data = [
            'title' => 'Pesanan',
            'order' => $order
        ];
        return view('orders.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrdersRequest $request, Orders $order)
    {
        if ($request->status == 1) {
            $order->quantity = $request->quantity;
            $order->total = str_replace('.', '', $request->total);
            $order->status = 1;
            $order->update();
        } else {
            $order->status = $order->status + 1;
            $order->update();
        }
        return redirect()->route('orders.index')->with('success', 'Pesanan Berhasil Diproses!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $order)
    {
        Gate::authorize('delete', $order);
        // delete product
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Hapus Pesanan Berhasil!');
    }

<<<<<<< HEAD
=======
    public function force(Orders $order)
    {
        // force delete the order
        $order->forceDelete();
        return redirect()->route('orders.trash')->with('success', 'Hapus Pesanan Berhasil!');
    }

>>>>>>> 50592e30327938efe0fa24c5660ee91cf020f77e
    public function completeOrder(Request $request)
    {
        // Validasi input
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'review' => 'required|string', // Sesuaikan validasi sesuai kebutuhan Anda
        ]);

        // Soft delete pesanan
        $order = Order::find($request->order_id);
        $order->delete();

        // Redirect atau berikan respon sesuai kebutuhan Anda
        return Redirect::to('/orders')->with('success', 'Pesanan berhasil diselesaikan.');
    }
<<<<<<< HEAD
=======


    public function trash()
    {
        if (Orders::onlyTrashed()->with(['product', 'user'])->get()->count() == 0) {
            return redirect()->route('orders.index');
        }
        $data = [
            'title' => 'Pesanan',
            'orders' => Orders::onlyTrashed()->with(['product', 'user'])->get()
        ];

        return view('orders.trash', $data);
    }

    public function restore(Orders $order)
    {
        // restore the order
        $order->restore();
        return redirect()->route('orders.trash')->with('success', 'Pesanan Berhasil Dikembalikan!');
    }
>>>>>>> 50592e30327938efe0fa24c5660ee91cf020f77e
}
