<div id="order-detail-by-order-id"
    class="fixed z-100 top-0 left-0 right-0 bottom-0 bg-white/20 backdrop-blur-lg flex items-center justify-center">
    <div class="bg-white shadow rounded p-4 w-full max-w-[500px]">
        <div class="h-full max-h-[300px] overflow-auto pb-5">
            <table class="w-full relative *:text-nowrap [&_th]:px-2 [&_th]:py-1 [&_td]:px-2 [&_td]:py-1">
                <tr class="sticky top-0 [&_th]:text-left bg-white">
                    <th>Row</th>
                    <th>PName</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Tax</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Created</th>
                </tr>
                @if (count($datas) <= 0)
                    <tr>
                        <td colspan="3" class="text-center italic">Cannot find "{{ $q }}"</td>
                    </tr>
                @else
                    @foreach ($datas as $key => $detail)
                        <tr class="relative hover:bg-black/10 transition-[background]">
                            <td class="text-center">{{ str_pad($key += 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td class="text-right">{{ number_format($detail->price, '0', ',', '.') }}</td>
                            <td class="text-center">{{ $detail->quantity }}</td>
                            <td class="text-right">{{ number_format($detail->subtotal, '0', ',', '.') }}</td>
                            <td class="text-right">{{ number_format($detail->tax, '0', ',', '.') }}</td
                                class="text-right">
                            <td class="text-right">{{ number_format($detail->discount, '0', ',', '.') }}</td
                                class="text-right">
                            <td class="text-right">{{ number_format($detail->total, '0', ',', '.') }}</td>
                            <td>{{ $detail->created_at }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="flex items-center justify-end gap-5 mt-4">
            <button type="button" onclick="document.getElementById('order-detail-by-order-id').remove()"
                class="px-4 py-1 text-neutral-700 font-bold">Close</button>
            <button type="button" class="px-4 py-1 font-bold bg-blue-400 text-white">Print</button>
        </div>
    </div>
</div>
