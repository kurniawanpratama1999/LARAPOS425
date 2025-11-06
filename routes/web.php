<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login');
});


Route::prefix("dashboard")->group(function () {
    Route::get("/", fn() => view('pages.dashboard.home'))->name("dashboard");
    Route::get("users/get-edit", [UserController::class, 'getEdit'])->name("users.getEdit");
    Route::get("users/get-delete", [UserController::class, 'getDelete'])->name("users.getDelete");
    Route::get("users", fn() => view('pages.dashboard.users'))->name("users");
});