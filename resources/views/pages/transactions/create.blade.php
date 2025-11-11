@extends('layouts.default')

@section('title', 'Create Transaction')

@section('content')
    <main class="relative grid grid-cols-[1fr_auto] h-dvh overflow-hidden">
        <section id="products" class="hidden"></section>
        <section id="products"></section>
        <section id="pos" class="w-[500px] bg-slate-300 flex flex-col">
            <div id="bills" class="font-mono grid grid-rows-[auto_1fr_auto] h-full">
                <div id="header" class="p-2 grid grid-cols-[auto_1fr] gap-2 bg-indigo-500 text-white text-xs">
                    <div>
                        <p>User</p>
                        <p>Date</p>
                        <p>Order</p>
                    </div>
                    <div>
                        <p>: Kurniawan Pratama</p>
                        <p>: Senin, 02 November 2025</p>
                        <p>: ORD20251102000001</p>
                    </div>
                </div>
                <div id="result">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="font-normal italic px-2 w-full">name</th>
                                <th class="font-normal italic px-2 ">qty</th>
                                <th class="font-normal italic px-2 ">price</th>
                                <th class="font-normal italic px-2 ">total</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div id="payment" class="p-3">
                <div id="input" class="mt-auto mb-3 grid grid-cols-[1fr_auto] gap-3">
                    <label for="product_id" class="text-right">
                        <input type="text" name="product_id" id="product_id" placeholder="product_id or product_id*qty"
                            class="w-full py-1 px-4 text-right border rounded">
                    </label>
                    <button type="button" class="px-5 rounded outline text-neutral-950">OK</button>
                </div>
                <div class="grid grid-cols-3 gap-3 text-center text-white font-bold *:outline">
                    <button type="button" class="px-3 py-1 rounded bg-emerald-500 outline-emerald-950">CASH</button>
                    <button type="button" class="px-3 py-1 rounded bg-blue-500 outline-blue-950">DEBIT</button>
                    <button type="button" class="px-3 py-1 rounded bg-pink-500 outline-pink-950">CREDIT</button>
                </div>
            </div>
            <div id="calc"
                class="p-2 flex flex-row items-center justify-between bg-indigo-500 text-white text-2xl font-bold">
                <div>
                    <p>Subtotal</p>
                    <p>Tax (11%)</p>
                    <p>Total</p>
                </div>
                <div class="text-right">
                    <p class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>100.000</span>
                    </p>
                    <p class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>11.000</span>
                    </p>
                    <p class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>111.000</span>
                    </p>
                </div>
            </div>
        </section>
    </main>
@endsection
