@if (count($datas) <= 0)
    <tr>
        <td colspan="7" class="text-center italic">Cannot find "{{ $q }}"</td>
    </tr>
@else
    @foreach ($datas as $key => $user)
        <tr class="relative hover:bg-black/10 transition-[background]">
                <td>
                    <div class='text-center'>{{ str_pad($key += 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <x-table.checkrow id="check-{{ $user['id'] }}" />
                </td>
                <td>
                    <div
                        class="size-9 outline-2 outline-neutral-400 rounded-full bg-slate-500 flex items-center justify-center overflow-hidden">
                        @if ($user['photo_profile'])
                            <img src="/storage/{{ $user['photo_profile'] }}" alt="{{ $user['name'] }}">
                        @else
                            <i class="bi bi-person-fill text-2xl text-slate-50 mb-1"></i>
                        @endif
                    </div>
                </td>
                <td class="pl-0!">{{ $user->name }}</td>
                <td>{{ $user->role->name}}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->status == 1)
                        Active
                    @elseif($user->status == 2)
                        Non Active
                    @else
                        Not Found
                    @endif
                </td>
                <td>{{ $user->created_at }}</td>
            </tr>
    @endforeach
@endif
