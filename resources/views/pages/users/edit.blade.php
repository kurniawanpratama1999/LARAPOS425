@extends('layouts.dashboard')
@section('title', 'Users | Larapos 425')
@section('content')
    Ini Halaman Edit Users {{ $id }}
@endsection

@section('btn-group')
    <button id="btn-add" onclick="btnAdd()" type="button"
        class="block size-10 rounded-full outline bg-emerald-500 text-white shadow">
        <i class="bi bi-plus"></i>
    </button>
    <button id="btn-delete" onclick="btnDelete()" type="button"
        class="cursor-pointer block size-10 disabled:hidden rounded-full outline bg-red-500 text-white shadow">
        <i class="bi bi-trash"></i>
    </button>
@endsection
