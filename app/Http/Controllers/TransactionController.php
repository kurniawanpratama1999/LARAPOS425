<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;

class TransactionController extends Controller
{
    public function index()
    {
        $datas = Order::with('orderDetails.product')->get();
        return view('pages.transactions.index', compact('datas',));
    }

    public function create()
    {
        $product = Product::with('categories')->get();
        $orders = Order::whereDate('created_at', now()->toDateString())->get();
        $today = date_format(now(), 'Ymd');
        $id = $orders->count() + 1;
        $runningID = "ORD" . $today . str_pad($id, 5, '0', STR_PAD_LEFT);
        return view('pages.transactions.create', compact('product', 'orders', 'runningID'));
    }

    public function search(Request $request)
    {
        $q = request()->query('q');

        $datas = Order::with('orderDetails.product');
        if ($q != '') {
            $datas->where(function ($query) use ($q) {
                $query
                    ->where('code', 'like', "%{$q}%")
                    ->orWhere('payment', 'like', "%{$q}%");
            });
        }

        $datas = $datas->get();
        logger()->info($q);
        logger()->info($datas);
        $html = view('partials.OrdersTableBody', compact('datas', 'q'))->render();

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
            'amount' => 'required|numeric|gte:total',

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
                    'price' => $detail['price'],
                    'quantity' => $detail['quantity'],
                    'subtotal' => $detail['subtotal'],
                    'tax' => $detail['tax'],
                    'discount' => $detail['discount'] ?? 0,
                    'total' => $detail['total'],
                ]);
            }
            DB::commit();

            $changes = number_format($validated['amount'] - $validated['total'], '0', ',', '.');
            $html = view('partials.ModalChangesPayment', compact('changes'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Order berhasil disimpan!',
                'order_code' => $order->code,
                'html' => $html,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan order',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    public function showDetail(Request $request)
    {
        try {
            $id = $request->query("id");
            $datas = OrderDetail::with('product')
                ->where('order_id', '=', $id)->get();

            logger()->info($datas);

            $html = view('partials.OrderDetailsTableBody', compact('datas'))->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => "gagal mendapatkan order detail"
            ]);
        }
    }

    public function debet()
    {

        try {
            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = config('midtrans.isSanitized');
            Config::$is3ds = config('midtrans.is3ds');
            
            $params = [
                'transaction_details' => [
                    'order_id' => rand(),
                    'gross_amount' => 10000,
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'snap' => $snapToken
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th
            ]);
        }
    }
}
