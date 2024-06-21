<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Orders;
use App\Models\Products;
use App\Events\AlertEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        $beforeRule = $request->method == '0' ? [] : ['required'];
        // create a new resource
        $credentials = Validator::make($request->all(), [
            'product' => ['required'],
            'method' => ['required'],
            'before' => $beforeRule,
            'after' => ['required'],
            'address' => $addressRule,
        ], [
            'product.required' => 'Layanan tidak boleh kosong!',
            'method.required' => 'Pilih metode pembayaran!',
            'before.required' => 'Pilih pengiriman awal!',
            'after.required' => 'Pilih pengiriman akhir!',
            'address.required' => 'Alamat Tidak Boleh Kosong!',
        ]);
        if (Auth::user()->phone == null) {
            return redirect()->back()->with('error', 'Isi nomor telpon terlebih dahulu!')->withErrors($credentials)->onlyInput('product', 'method', 'before', 'after', 'address', 'note');
        }
        if ($credentials->fails()) {
            return redirect()->back()->with('error', 'Tambah pesanan gagal!')->withErrors($credentials)->onlyInput('product', 'method', 'before', 'after', 'address', 'note');
        }
        // create a new order
        $order = new Orders();
        $order->code = Products::find($request->product)->code . sprintf("%06s", (int)substr(Orders::withTrashed()->where('code', 'like', Products::find($request->product)->code . '%')->get()->last()->code ?? 0, -6) + 1);
        $order->user_id = Auth::user()->id;
        $order->product_id = $request->product;
        $order->method = $request->method;
        $order->before = $request->method == 1 ? $request->before : '0';
        $order->after = $request->after;
        $order->address = $request->address;
        $order->status = 0;
        $order->save();
        $order->user_name = $order->user->name;
        $order->product_name = $order->product->name;
        // event(new AlertEvent(
        //     role: [1, 2],
        //     user_id: 0,
        //     time: Carbon::now()->diffForHumans(),
        //     alert: '<b>' . Auth::user()->name . '</b> membuat pesanan baru!',
        //     color: 'secondary',
        //     icon: 'fa-solid fa-people-carry-box',
        //     link: '/orders/' . $order->code
        // ));
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $order)
    {
        Gate::authorize('view', $order);
        $order ?? abort(404);

        //tanggal
        $date = Carbon::parse($order->created_at)->locale('id')->translatedFormat('l, d F Y');

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
        if (Auth::user()->role == 3) {
            // validate
            $credentials = Validator::make($request->all(), [
                'review' => ['required', 'min:30'],
            ], [
                'review.required' => 'Ulasan Tidak Boleh Kosong!',
                'review.min' => 'Ulasan minimal 30 karakter!',
            ]);

            if ($credentials->fails()) {
                return redirect()->back()->with('error', 'Tambah ulasan gagal!')->withErrors($credentials)->onlyInput('review');
            }

            $order->review = $request->review;
            $order->status = $order->status + 1;
            $order->update();
            // event(new AlertEvent(
            //     role: [1, 2],
            //     user_id: 0,
            //     time: Carbon::now()->diffForHumans(),
            //     alert: '<b>' . Auth::user()->name . '</b> menambahkan ulasan!',
            //     color: 'secondary',
            //     icon: 'fa-solid fa-people-carry-box',
            //     link: '/orders/' . $order->code
            // ));
        } else {
            if ($request->status == 1) {
                $order->quantity = $request->quantity;
                $order->total = str_replace('.', '', $request->total);
                $order->status = 1;
                $order->staff_id = Auth::user()->id;
                $order->update();

                // event(new AlertEvent(
                //     role: [1, 2],
                //     user_id: 0,
                //     time: Carbon::now()->diffForHumans(),
                //     alert: 'Pesanan dengan nomor <b>' . $order->code . '</b> menunggu pembayaran!',
                //     color: 'secondary',
                //     icon: 'fa-solid fa-people-carry-box',
                //     link: '/orders/' . $order->code
                // ));
                // event(new AlertEvent(
                //     role: [],
                //     user_id: $order->user_id,
                //     time: Carbon::now()->diffForHumans(),
                //     alert: 'Pesanan dengan nomor <b>' . $order->code . '</b> menunggu pembayaran!',
                //     color: 'secondary',
                //     icon: 'fa-solid fa-people-carry-box',
                //     link: '/orders/' . $order->code
                // ));
            } else {
                $order->staff_id = Auth::user()->id;
                $order->status = $order->status + 1;
                $order->update();
                // event(new AlertEvent(
                //     role: [1, 2],
                //     user_id: 0,
                //     time: Carbon::now()->diffForHumans(),
                //     alert: 'Pesanan dengan nomor <b>' . $order->code . '</b> menuju tahap selanjutnya!',
                //     color: 'secondary',
                //     icon: 'fa-solid fa-people-carry-box',
                //     link: '/orders/' . $order->code
                // ));
                // event(new AlertEvent(
                //     role: [],
                //     user_id: $order->user_id,
                //     time: Carbon::now()->diffForHumans(),
                //     alert: 'Pesanan dengan nomor <b>' . $order->code . '</b> menuju tahap selanjutnya!',
                //     color: 'secondary',
                //     icon: 'fa-solid fa-people-carry-box',
                //     link: '/orders/' . $order->code
                // ));
            }
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

        return redirect()->route('orders.index')->with('success', 'Hapus pesanan berhasil!');
    }

    public function force(Orders $order)
    {
        // force delete the order
        $order->forceDelete();
        return redirect()->route(Orders::onlyTrashed()->count() > 0 ? 'orders.trash' : 'orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }



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
        if ($order->user == null) {
            return redirect()->route(Orders::onlyTrashed()->count() > 0 ? 'orders.trash' : 'orders.index')->with('error', 'Pengguna tidak tersedia!');
        } elseif ($order->product == null) {
            return redirect()->route(Orders::onlyTrashed()->count() > 0 ? 'orders.trash' : 'orders.index')->with('error', 'Layanan tidak tersedia!');
        }
        // restore the order
        $order->restore();
        return redirect()->route(Orders::onlyTrashed()->count() > 0 ? 'orders.trash' : 'orders.index')->with('success', 'Pesanan berhasil dipulihkan!');
    }
}
