@extends('layouts.default')

@section('title', 'Create Transaction')

@section('content')
    <main class="relative grid grid-cols-[1fr_auto] h-dvh overflow-hidden">
        <section id="information" class="hidden"></section>
        <section id="product-wrapper" class="grid grid-rows-[auto_1fr]">
            <div class="h-20 flex flex-row items-center justify-center px-4">
                <div class="bg-white shadow flex items-center px-3 py-1 rounded-full w-full max-w-xl">
                    <label for="search" class="w-full max-w-[450px] border-r">
                        <input type="search" name="search" id="search" autocomplete="off" autocorrect="off" placeholder="Search product" class="px-3 py-1 rounded-full w-full">
                    </label>
                    <label for="categories" class="w-36">
                        <select name="categories" id="categories" class="px-3 py-1 w-full">
                            <option value="">Makanan</option>
                            <option value="">Minuman</option>
                        </select>
                    </label>

                </div>
            </div>
            <div id="products" class="h-[calc(100dvh-5rem)] overflow-auto">
                <div class="p-3 grid grid-cols-[repeat(auto-fit,250px)] gap-5 justify-center">
                    @foreach ($product as $p)
                    <div onclick="addProduct('{{ $p->id }}|{{ $p->name }}|{{ $p->categories->name }}|{{ $p->price }}')" class="bg-neutral-100 p-3 rounded cursor-pointer hover:shadow hover:scale-105 transition-all">
                        <div class="aspect-square mb-2"></div>
                        <h2>{{ $p->name }}</h2>
                        <p>{{ $p->categories->name }}</p>
                        <p>Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section id="pos" class="w-[500px] bg-neutral-100 flex flex-col">
            <div id="bills" class="font-mono grid grid-rows-[auto_1fr_auto] h-full">
                <div id="header" class="p-2 grid grid-cols-[auto_1fr] items-center gap-2 bg-indigo-500 text-white text-xs h-20">
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
                            <tr class="text-left">
                                <th class="font-normal italic px-2 w-full">name</th>
                                <th class="font-normal italic px-2 text-center">qty</th>
                                <th class="font-normal italic px-2 text-right">price</th>
                                <th class="font-normal italic px-2 text-right">total</th>
                            </tr>
                        </thead>
                        <tbody id="theChoosenProduct">
                        </tbody>
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
                    <button type="button" onclick="paymentCash()" class="px-3 py-1 rounded bg-emerald-500 outline-emerald-950">CASH</button>
                    <button type="button" class="px-3 py-1 rounded bg-blue-500 outline-blue-950">DEBIT</button>
                    <button type="button" class="px-3 py-1 rounded bg-pink-500 outline-pink-950">CREDIT</button>
                </div>
            </div>
            <div
                class="p-2 flex flex-row items-center justify-between bg-indigo-500 text-white text-2xl font-bold">
                <div>
                    <p>Subtotal</p>
                    <p>Tax (11%)</p>
                    <p>Total</p>
                </div>
                <div id="calc" class="text-right">
                    <p id="subtotal" class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>0</span>
                    </p>
                    <p id="tax" class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>0</span>
                    </p>
                    <p id="total" class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>0</span>
                    </p>
                </div>
            </div>
        </section>
    </main>


    @pushOnce('scripts')
        <script>
            const setProducts = {value: []}
            const setSendToFetch = {value: []}
            const setCalc = {value: []}

            const numberToNominal = (n) => {
                return new Intl.NumberFormat("id-ID", {
                    style: 'decimal'
                }).format(n)
            }

            const displayCollectingIDonBills = () => {
                const theChoosenProductEl = document.getElementById('theChoosenProduct')
                const calcEl = document.getElementById('calc')

                setProducts.value = setProducts.value.map(v => ({
                    ...v,
                    id: parseInt(v.id),
                    price: parseInt(v.price),
                    subtotal: v.qty * v.price,
                    tax: (v.qty * v.price) * 0.11,
                    total: ((v.qty * v.price) * 0.11) + (v.qty * v.price),
                }))


                const subtotal = setProducts.value.reduce((a,b) => a + b.subtotal, 0)
                const tax = subtotal * .11
                const total = subtotal + tax

                setCalc.value = {subtotal, tax, total}

                calcEl.innerHTML = calcHTML(subtotal, tax, total)
                document.getElementById('theChoosenProduct' ).innerHTML = setProducts.value.map(v => billsHTML(v)).join('\n');
            }

            const displayPopupEditingQty = (id) => {
                document.body.insertAdjacentHTML('afterbegin', modalEditProductHTML(id))
            }

            const incrementProduct = (id) => {
                const qtyFormatElement = document.getElementById('qtyFormat');
                const findID = setProducts.value.find(v => v.id == id)
                if (findID) {

                    findID.qty += 1

                    if (qtyFormatElement) {
                        qtyFormatElement.value = findID.qty;
                    }
                }

                displayCollectingIDonBills()
            }
            const decrementProduct = (id) => {
                const qtyFormatElement = document.getElementById('qtyFormat');
                const findID = setProducts.value.find(v => v.id == id)
                if (findID && findID.qty >= 1) {
                    findID.qty -= 1

                    if (qtyFormatElement) {
                        qtyFormatElement.value = findID.qty;
                    }
                }

                if (findID && findID.qty < 1) {
                    setProducts.value = setProducts.value.filter(v => v.id !== id)
                    document.getElementById('popup-edit-qty').remove()
                }

                displayCollectingIDonBills()
            }
            const deleteProduct = (id) => {
                const findID = setProducts.value.find(v => v.id == id)
                if (findID) {
                    setProducts.value = setProducts.value.filter(v => v.id !== id)
                    document.getElementById('popup-edit-qty').remove()
                }

                displayCollectingIDonBills()
            }

            const addProduct = (strData) => {
                const [id, name, categories, price] = strData.split('|')
                const findID = setProducts.value.find(v => v.id == id)

                if (findID) {
                    findID.qty += 1
                } else {
                    setProducts.value.push({id,name,categories,price,qty:1})
                }

                displayCollectingIDonBills()
            }

            const changeQty = (id) => {
                const findID = setProducts.value.find(v => v.id == id)
                const self = document.getElementById('qtyFormat')

                if (findID) {
                    findID.qty = self.value
                    document.getElementById('popup-edit-qty').remove()
                }

                displayCollectingIDonBills()
            }

            const calcHTML = (subtotal, tax, total) => {
                return `
                    <p id="subtotal" class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>${numberToNominal(subtotal)}</span>
                    </p>
                    <p id="tax" class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>${numberToNominal(tax)}</span>
                    </p>
                    <p id="total" class="flex flex-row items-center justify-between w-full gap-2">
                        <span>Rp</span>
                        <span>${numberToNominal(total)}</span>
                    </p>`
            }

            const billsHTML = (v) => {
                return `<tr onclick="displayPopupEditingQty(${v.id})" id="row-${v.id}">
                    <td id="name-${v.id}" class="px-2">${v.name}</td>
                    <td id="qty-${v.id}" class="px-2">${v.qty}</td>
                    <td id="price-${v.id}" class="px-2">
                        <div class="flex flex-row items-center justify-between w-full gap-2">
                            <span>Rp</span>
                            <span>${numberToNominal(v.price + (v.price * .11))}</span>
                        </div>
                    </td>
                    <td id="total-${v.id}" class="px-2">
                        <div class="flex flex-row items-center justify-between w-full gap-2">
                            <span>Rp</span>
                            <span>${numberToNominal(v.total)}</span>
                        </div>
                    </td>
                </tr>`;
            }

            const modalEditProductHTML = (id) => {
                getProductByID = setProducts.value.find(v => v.id === id);

                return `<div id="popup-edit-qty" class="fixed top-0 left-0 w-full h-full bg-white/20 flex items-center justify-center z-100 backdrop-blur-md">
                    <div class="flex flex-col items-end justify-between gap-2 bg-white p-5 rounded shadow">
                        <h3 class="w-full text-center">${getProductByID.name}</h3>
                        <label class="flex outline">
                            <button onclick="decrementProduct(${id})" type="button" class="px-3 py-1 bg-red-500 font-bold text-white">-</button>
                            <input onchange="changeQty(${id})" id="qtyFormat" value="${getProductByID.qty}" class="text-center">
                            <button onclick="incrementProduct(${id})" type="button" class="px-3 py-1 bg-emerald-500 font-bold text-white">+</button>
                        </label>
                        <div class="flex items-center justify-between gap-2">
                            <button class="font-bold px-3 py-1" type="button" onclick="document.getElementById('popup-edit-qty').remove()">Close</button>
                            <button class="px-3 py-1 bg-red-300 font-bold text-white" type="button" onclick="deleteProduct(${id})">Delete</button>
                        </div>
                    </div>
                </div>
                    `
            }

            const modalPaymentCashHTML = () => {
                const {subtotal, tax, total} = setCalc.value
                return `
                <div id="popup-payment-cash" class="fixed top-0 left-0 w-full h-full bg-white/20 flex items-center justify-center z-100 backdrop-blur-md">
                    <div class="flex flex-col items-end gap-2 bg-white p-5 rounded shadow">
                        <h3 class="text-center font-bold text-2xl">Cash Payment</h3>
                        <div class="p-2 flex flex-row text-xl gap-5">
                            <div class='w-full'>
                                <p>Subtotal</p>
                                <p>Tax (11%)</p>
                                <p>Total</p>
                                <p>Cash</p>
                            </div>

                            <div class="text-right">
                                <p id="subtotal2">
                                    <span>Rp ${numberToNominal(subtotal)}</span>
                                </p>
                                <p id="tax2">
                                    <span>Rp ${numberToNominal(tax)}</span>
                                </p>
                                <p id="total2">
                                    <span>Rp ${numberToNominal(total)}</span>
                                </p>
                                <p id="total-cash">
                                    <label>
                                        <input value="${total}" class="text-right">
                                    </label>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center gap-5">
                            <button type="button" onclick="document.getElementById('popup-payment-cash').remove()">Cancel</button>
                            <button type="button" class="py-1 px-5 bg-emerald-400 text-white rounded">Pay</button>
                        </div>
                    </div>
                </div>
                    `
            }

            const paymentCashDeal = () => {
                alert('i')
            }

            const paymentCash = () => {
                document.body.insertAdjacentHTML('afterbegin', modalPaymentCashHTML())
            }
        </script>
    @endPushOnce
@endsection
