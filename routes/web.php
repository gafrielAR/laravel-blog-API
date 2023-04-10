<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::name('post.')->prefix('post')->group(function() {
    Route::get('/', [PostController::class, 'list'])->name('list');
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
    Route::post('/create', [PostController::class, 'create'])->name('create');
    Route::post('/update/{id}', [PostController::class, 'update'])->name('update');
    Route::post('/delete/{id}', [PostController::class, 'delete'])->name('delete');
});