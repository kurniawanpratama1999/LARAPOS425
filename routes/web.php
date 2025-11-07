<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Integer;

Route::get('/', function () {
    return view('pages.login');
});


Route::prefix("dashboard")->group(function () {
    Route::get("/", fn() => view('pages.dashboard.home'))->name("dashboard");

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/edit/{id}', fn($id) => (new UserController())->edit($id))
                ->whereNumber('id')->name('users.edit');

        Route::get('/search', [UserController::class, 'search'])->name('users.search');

        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::put('/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('/destroys', [UserController::class, 'destroys'])->name('users.destroys');
    });
});
