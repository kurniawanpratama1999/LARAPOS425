@props(['users' => []])

 @foreach ($users as $user)
    <tr id="row-data-{{ $user['id'] }}"
        class="relative [&>td]:px-3 [&>td]:text-nowrap [&>td]:py-2 border-b border-slate-300 hover:bg-slate-100 has-checked:bg-amber-100">
        <td id="check-{{ $user['id'] }}">
            <label for="check-{{ $user['id'] }}">
                <input type="checkbox" name="check-{{ $user['id'] }}" id="check-{{ $user['id'] }}">
            </label>
        </td>
        <td id="name-{{ $user['id'] }}">{{ $user['name'] }}</td>
        <td id="role-{{ $user['id'] }}">{{ $user['role_id'] }}</td>
        <td id="email-{{ $user['id'] }}">{{ $user['email'] }}</td>
        <td id="status-{{ $user['id'] }}">{{ $user['status'] }}</td>
        <td id="created-{{ $user['id'] }}">{{ $user['created_at'] }}</td>
    </tr>
@endforeach
