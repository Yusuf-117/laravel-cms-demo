<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ArticleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn() => Inertia::render('Home'))->name('Home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('admin.dashboard');

        Route::resource('categories', CategoryController::class)
            ->except(['show']);

        Route::resource('articles', ArticleController::class)
            ->except(['show']);
    });
