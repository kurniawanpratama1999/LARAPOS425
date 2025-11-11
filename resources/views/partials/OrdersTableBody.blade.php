@if (count($datas) > 0)
    @foreach ($datas as $order)
        <tr onclick="showDetail({{ $order->id }})" class="relative hover:bg-black/10 transition-[background]">
            <td>{{ $order->code }}</td>
            <td>{{ $order->payment }}{{ $order->payment_tool ? '/' . $order->paymet_tool : '' }}{{ $order->payment_detail ? '/' . $order->paymet_detail : '' }}
            </td>
            <td>{{ $order->quantities }}</td>
            <td>{{ number_format($order->subtotal, 0, ',', '.') }}</td>
            <td>{{ number_format($order->tax, 0, ',', '.') }}</td>
            <td>{{ number_format($order->discount, 0, ',', '.') }}</td>
            <td>{{ number_format($order->total, 0, ',', '.') }}</td>
            <td>{{ $order->created_at }}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8">Tidak dapat menemukan <span class="italic">"{{ $q }}"</span></td>
    </tr>
@endif
