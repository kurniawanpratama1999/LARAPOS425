<?php

use App\Http\Controllers\{UserController, RoleController, CategoriesController, ProductController};
use Illuminate\Support\Facades\Route;

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

    Route::get('/categories/search', [CategoriesController::class, 'search'])->name('categories.search');
    Route::post('/categories/destroys', [CategoriesController::class, 'destroys'])->name('categories.destroys');
    Route::resource("categories", CategoriesController::class);

    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::post('/products/destroys', [ProductController::class, 'destroys'])->name('products.destroys');
    Route::resource("products", ProductController::class);
});
