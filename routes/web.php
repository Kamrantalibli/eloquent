<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\ArticleController;
use \App\Http\Controllers\Admin\CategoryController;

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
    return view('admin.index');
})->name("home");

Route::get('articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('articles/create', [ArticleController::class, 'create'])->name('article.create');

Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('categories/create', [CategoryController::class, 'create'])->name('category.create');