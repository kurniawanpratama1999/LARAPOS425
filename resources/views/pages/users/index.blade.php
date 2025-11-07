@extends('layouts.dashboard')
@section('title', 'Users | Larapos 425')
@section('content')
    <table id="datas" class="w-full relative [&_th]:text-nowrap [&_td]:text-nowrap">
        <thead
            class="sticky top-0 z-1 bg-neutral-200 text-left [&_th]:px-3 [&_th]:py-3 [&_th]:border-b-2 [&_th]:border-slate-300">
            <tr>
                <th class="text-center">row</th>
                <th colspan="2">name</th>
                <th>role</th>
                <th>email</th>
                <th>status</th>
                <th>created</th>
            </tr>
        </thead>
        <tbody class="[&_td]:px-3 [&_td]:py-2 [&_td]:border-b [&_td]:border-slate-300">
            @foreach ($datas as $user)
                <tr class="relative hover:bg-black/10 transition-[background]">
                    <td>
                        <label for="check-{{ $user['id'] }}" class="flex w-full items-center justify-center">
                            <input type="checkbox" name="check-{{ $user['id'] }}" id="check-{{ $user['id'] }}">
                        </label>
                    </td>
                    <td><i class="bi bi-person-circle text-4xl"></i></td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['role_id'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['status'] }}</td>
                    <td>{{ $user['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('btn-group')
    <button id="btn-add" onclick="btnAdd()" type="button"
        class="block size-12 rounded-full outline bg-emerald-500/20 hover:bg-emerald-500 text-white shadow">
        <i class="bi bi-plus text-2xl"></i>
    </button>
    <button id="btn-delete" onclick="btnDelete()" type="button"
        class="cursor-pointer block size-12 disabled:hidden rounded-full outline bg-red-500/20 hover:bg-red-500 text-white shadow">
        <i class="bi bi-trash"></i>
    </button>
@endsection

@pushOnce('scripts')
    <script type="module" src="{{ Vite::asset('resources/js/bladeMain.js') }}"></script>
@endPushOnce
