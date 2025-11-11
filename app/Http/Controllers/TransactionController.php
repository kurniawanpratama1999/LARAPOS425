<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use DB;
use Hash;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {   
        $datas = Order::with('orderDetails.product.categories' )->get();
        return view('pages.transactions.index', compact('datas',));
    }

    public function create()
    {
        $product = Product::with('categories')->get();
        return view('pages.transactions.create', compact('product'));
    }
    // public function edit(string $id)
    // {
    // }
    public function search(Request $request)
    {
        $q = request()->query('q');

        $datas = Order::with('orderDetails.product.categories');
        if ($q != '') {
            $datas = Order::with('orderDetails.product.categories')
                ->when($q != '', function ($query) use ($q) {
                    $query->where(function ($qMain) use ($q) {
                        $qMain
                            ->where('code', 'like', "%{$q}%")
                            ->orWhere('payment', 'like', "%{$q}%")
                            ->orWhere('payment_tool', 'like', "%{$q}%")
                            // cari di tabel produk
                            ->orWhereHas('orderDetails.product', function ($p) use ($q) {
                                $p->where(function ($inner) use ($q) {
                                    $inner->where('name', 'like', "%{$q}%")
                                        ->orWhere('description', 'like', "%{$q}%")
                                        ->orWhere('price', 'like', "%{$q}%");
                                });
                            })
                            // cari juga di tabel kategori produk
                            ->orWhereHas('orderDetails.product.categories', function ($c) use ($q) {
                                $c->where('name', 'like', "%{$q}%");
                            });
                    });
                })
                ->get();

        }

        $datas = $datas->get();

        $html = view('partials.OrderDetailsTableBody', compact('datas', 'q'))->render();

        return response()->json(['html' => $html]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string|unique:orders,code',
            'payment' => 'required|string',
            'payment_tool' => 'nullable|string',
            'payment_detail' => 'nullable|string',
            'quantities' => 'required|integer',
            'subtotal' => 'required|numeric',
            'tax' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'total' => 'required|numeric',

            // 🔹 Validasi untuk detail (array)
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.price' => 'required|numeric',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.subtotal' => 'required|numeric',
            'details.*.tax' => 'required|numeric',
            'details.*.discount' => 'nullable|numeric',
            'details.*.total' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
                $order = Order::create([
                    'user_id' => $validated['user_id'],
                    'code' => $validated['code'],
                    'payment' => $validated['payment'],
                    'payment_tool' => $validated['payment_tool'],
                    'payment_detail' => $validated['payment_detail'],
                    'quantities' => $validated['quantities'],
                    'subtotal' => $validated['subtotal'],
                    'tax' => $validated['tax'],
                    'discount' => $validated['discount'] ?? 0,
                    'total' => $validated['total'],
                ]);

                foreach ($validated['details'] as $detail) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $detail['product_id'],
                        'subtotal' => $detail['subtotal'],
                        'quantity' => $detail['quantity'],
                        'tax' => $detail['tax'],
                        'discount' => $detail['discount'] ?? 0,
                        'total' => $detail['total'],
                    ]);
                }
            DB::commit();

            return response()->json([
                    'message' => 'Order berhasil disimpan!',
                    'order_code' => $order->code,
                ], 201);

        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan order',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    // public function update(Request $request, string $id)
    // {

    // }

    // public function destroys(Request $request)
    // {
        
    // }
}
