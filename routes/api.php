<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('posts.')->prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('list');
    Route::get('/read', [PostController::class, 'show'])->name('show');
    Route::post('/create', [PostController::class, 'create'])->name('create');
    Route::put('/update', [PostController::class, 'update'])->name('update');
    Route::delete('/destroy', [PostController::class, 'destroy'])->name('destroy');
});

Route::name('categories.')->prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('list');
    Route::get('/read', [CategoryController::class, 'show'])->name('show');
    Route::post('/create', [CategoryController::class, 'create'])->name('create');
    Route::put('/update', [CategoryController::class, 'update'])->name('update');
    Route::delete('/destroy', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
