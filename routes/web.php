<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\DocsController;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
Route::domain('cms.' . config('app.domain'))->group(function () {
    Route::get('/', [DocsController::class, 'index'])->name('home');
    Route::get('/docs/categories/{category:slug}', [DocsController::class, 'category'])->name('docs.categories.show');
    Route::get('/docs/articles/{article:slug}', [DocsController::class, 'article'])->name('docs.articles.show');
    Route::get('/search', [DocsController::class, 'search'])->name('docs.search');

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

            // viewer + editor
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
            Route::get('/media', [MediaController::class, 'index'])->name('media.index');
            Route::get('/media/list', [MediaController::class, 'list'])->name('media.list');

            Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');
            Route::get('articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

            Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

            // editor only
            Route::middleware('can:manage-content')->group(function () {

                Route::get('/import', [ImportController::class, 'create'])->name('admin.import');
                Route::post('/import', [ImportController::class, 'store'])
                    ->middleware('can:manage-content')
                    ->name('admin.import.store');

                Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
                Route::put('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
                Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

                Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
                Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
                Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

                Route::post('/media/upload', [MediaController::class, 'store'])->name('media.store');
            });
        });
});


Route::get('/', function () {
    return view('portfolio');
});
