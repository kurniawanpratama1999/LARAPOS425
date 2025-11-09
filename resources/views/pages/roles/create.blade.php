@extends('layouts.dashboard')
@section('title', 'roles | Larapos 425')
@section('content')
    <div class="flex flex-col items-center p-3">
        <div class="max-w-lg">
            @if (isset($datas))
                <x-alert title="information" type="info">
                    Pastikan kamu mengeditnya dengan data role name yang belum ada.
                </x-alert>
            @else
                <x-alert title="information" type="info">
                    Role name haruslah unik, jadi pastikan kamu membuat nama yang memang belum ada.
                </x-alert>
            @endif

            <div class="my-3">
                <h2 class="text-2xl {{ !isset($datas) ? 'text-emerald-400' : 'text-indigo-400' }} font-bold">
                    @if (isset($datas))
                        Update For {{ $datas->name }}
                    @else
                        Create New Role
                    @endif
                </h2>

                <p class="text-justify">
                    @if (isset($datas))
                        Data ini akan diperbaharui oleh administrator. Pastikan diperbaharui dengan
                        benar.
                    @else
                        Data ini digunakan sebagai relasi untuk si Users.
                    @endif
                </p>
            </div>

            <form action="{{ !isset($datas) ? route('roles.store') : route('roles.update', $datas->id) }}" method="post"
                class="p-2 w-full max-w-lg space-y-5">
                @csrf
                @if (isset($datas))
                    @method('PUT')
                @endif

                <x-form.input required label="Role Name" id="name" type="text" :model="$datas ?? null" autofocus />

                <div class="flex flex-row gap-4 justify-end">
                    <button type="reset" class="font-bold w-20">Reset</button>

                    <button type="submit"
                        class="font-bold w-20 {{ !isset($datas) ? 'bg-emerald-400 hover:bg-emerald-500' : 'bg-indigo-400 hover:bg-indigo-500' }} py-1 rounded text-white cursor-pointer">
                        @if (isset($datas))
                            Update
                        @else
                            Save
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
