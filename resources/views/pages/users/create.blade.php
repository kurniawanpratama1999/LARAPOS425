@extends('layouts.dashboard')
@section('title', 'Users | Larapos 425')
@section('content')
    <div class="flex flex-col items-center p-3">
        <div class="max-w-lg">
            @if (isset($datas))
                <x-alert title="information" type="info">
                    Isi password untuk mengubah password lama menjadi password baru, artinya jangan isi password kalau tidak
                    mau ada perubahan pada password.
                </x-alert>
            @else
                <x-alert title="information" type="info">
                    Pastikan kamu mengisi datanya dengan benar, <b>nama</b> harus <b>sesuai KTP</b>, <b>email pribadi</b>
                    harus <b>terdaftar</b>, dan <b>password</b> haruslah <b>aman</b> dan <b>mudah di ingat</b>.
                </x-alert>
            @endif

            <div class="my-3">
                <h2 class="text-2xl {{ !isset($datas) ? 'text-emerald-400' : 'text-indigo-400' }} font-bold">
                    @if (isset($datas))
                        Update For {{ $datas->name }}
                    @else
                        Create New User
                    @endif
                </h2>

                <p class="text-justify">
                    @if (isset($datas))
                        Data ini akan diperbaharui oleh administrator. Pastikan diperbaharui dengan
                        benar.
                    @else
                        Data ini akan ditampilkan oleh si pengguna dan administrator.
                    @endif
                </p>
            </div>

            <form action="{{ !isset($datas) ? route('users.store') : route('users.update', $datas->id) }}" method="post"
                class="p-2 w-full max-w-lg space-y-5">
                @csrf
                @if (isset($datas))
                    @method('PUT')
                @endif

                <x-form.input required label="Full name" id="name" type="text" :model="$datas ?? null" autofocus />

                <x-form.select required label="Role name" id="role_id" :datas="$roles" :value="$datas?->role_id ?? ''" />

                <x-form.input required label="Email Address" id="email" type="email" :model="$datas ?? null" />

                @if (isset($datas))
                    <x-form.select required label="Status" id="status" :datas="collect([
                        (object)['id' => 1, 'name' => 'Active'],
                        (object)['id' => 0, 'name' => 'Non Active'],
                    ])" :value="$datas?->status ?? ''"/>
                @endif

                <x-form.input required="{{ isset($datas) ? 0 : 1 }}"
                    label="{{ isset($datas) ? 'New Password' : 'Password' }}" id="password" type="password" />
                <x-form.input required="{{ isset($datas) ? 0 : 1 }}" label="Confirm password" id="password_confirmation"
                    type="password" />

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
