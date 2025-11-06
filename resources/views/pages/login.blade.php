@extends('layouts.default')
@section('title', 'Login | Larapos 425')
@section('content')
    <main class="flex items-center justify-center flex-col gap-3 h-full">
        <div class="text-center text-indigo-400">
            <h1 class="text-3xl font-bold">LARAPOS 425</h1>
            <h2 class="text-2xl font-bold">Please sign in to your account</h2>
        </div>
        <form class="form-input flex flex-col items-center gap-5" action="" method="POST">
            <label for="email" class="flex flex-col border border-indigo-300 p-2 rounded-md gap-1">
                <span class="text-sm">Email Address <small>*</small></span>
                <input type="text" name="email" id="email" class="w-sm border-0 outline-0">
            </label>

            <label for="password" class="flex flex-col border border-indigo-300 p-2 rounded-md gap-1">
                <span class="text-sm">Password <small>*</small></span>
                <input type="text" name="password" id="password" class="w-sm border-0 outline-0">
            </label>

            <button type="submit" class="bg-indigo-300 py-3 rounded-md px-5 w-full text-white font-bold">Login</button>
        </form>
    </main>
@endsection
