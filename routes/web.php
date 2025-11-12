<?php

use App\Http\Controllers\{UserController, RoleController, CategoriesController, LoginController, ProductController};
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::prefix("dashboard")->group(function () {
        Route::get("/", fn() => view('pages.dashboard.home'))->name("dashboard");

        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
        Route::post('/users/destroys', [UserController::class, 'destroys'])->name('users.destroys');
        Route::resource("users", UserController::class);

        Route::get('/roles/search', [RoleController::class, 'search'])->name('roles.search');
        Route::post('/roles/destroys', [RoleController::class, 'destroys'])->name('roles.destroys');
        Route::resource("roles", RoleController::class);

        Route::get('/categories/search', [CategoriesController::class, 'search'])->name('categories.search');
        Route::post('/categories/destroys', [CategoriesController::class, 'destroys'])->name('categories.destroys');
        Route::resource("categories", CategoriesController::class);

        Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
        Route::post('/products/destroys', [ProductController::class, 'destroys'])->name('products.destroys');
        Route::resource("products", ProductController::class);

        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
        Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
        Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');

        Route::get('/transaction/search', [TransactionController::class, 'search'])->name('transaction.search');
        Route::get('/transaction/detail', [TransactionController::class, 'showDetail'])->name('transaction.detail');

        Route::post('/transaction/debet', [TransactionController::class, 'debet'])->name('transaction.debet');
    });
});
