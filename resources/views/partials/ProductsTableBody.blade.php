@if (count($datas) <= 0)
    <tr>
        <td colspan="8" class="text-center italic">Cannot find "{{ $q }}"</td>
    </tr>
@else
    @foreach ($datas as $key => $product)
        <tr class="relative hover:bg-black/10 transition-[background]">
            <td>
                <div class='text-center'>{{ str_pad($key += 1, 2, '0', STR_PAD_LEFT) }}</div>
                <x-table.checkrow id="check-{{ $product->id }}" />
            </td>
            <td>
                <div
                    class="size-9 outline-2 outline-neutral-400 rounded-full bg-slate-500 flex items-center justify-center overflow-hidden">
                    @if ($product->photo_profile)
                        <img src="/storage/{{ $product->photo_profile }}" alt="{{ $product->name }}">
                    @else
                        <i class="bi bi-person-fill text-2xl text-slate-50 mb-1"></i>
                    @endif
                </div>
            </td>
            <td class="pl-0!">{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>
                @if ($product->status = 1)
                    Active
                @elseif($product->status = 2)
                    Non Active
                @else
                    Not Found
                @endif
            </td>
            <td>{{ $product->created_at }}</td>
        </tr>
    @endforeach
@endif
