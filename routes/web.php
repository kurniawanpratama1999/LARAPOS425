<?php

use App\Http\Controllers\{UserController, RoleController};
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Integer;

Route::get('/', function () {
    return view('pages.login');
});


Route::prefix("dashboard")->group(function () {
    Route::get("/", fn() => view('pages.dashboard.home'))->name("dashboard");

    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::post('/users/destroys', [UserController::class, 'destroys'])->name('users.destroys');
    Route::resource("users", UserController::class);

    Route::get('/roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::post('/roles/destroys', [RoleController::class, 'destroys'])->name('roles.destroys');
    Route::resource("roles", RoleController::class);
});
