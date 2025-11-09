@if (count($datas) <= 0)
    <tr>
        <td colspan="3" class="text-center italic">Cannot find "{{ $q }}"</td>
    </tr>
@else
    @foreach ($datas as $key => $category)
        <tr class="relative hover:bg-black/10 transition-[background]">
            <td>
                <div class='text-center'>{{ str_pad($key += 1, 2, '0', STR_PAD_LEFT) }}</div>
                <x-table.checkrow id="check-{{ $category->id }}" />
            </td>
            <td class="pl-0!">{{ $category->name }}</td>
            <td>{{ $category->created_at }}</td>
        </tr>
    @endforeach
@endif
