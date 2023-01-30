<?php

use App\Http\Controllers\ProfileController;
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


Route::get('/', [\App\Http\Controllers\CatalogController::class, 'index'])->name('index');

Route::group([
    'as' => 'catalog.',
    'prefix' => 'catalog',
], function() {
    Route::get('/{category:slug}', [\App\Http\Controllers\CatalogController::class, 'category'])->name('category');
    Route::get('/{category:slug}/{product:slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product');
});


Route::group([
    'as' => 'basket.',
    'prefix' => 'basket',
], function() {
    Route::get('/index', [\App\Http\Controllers\BasketController::class, 'index'])->name('index');
    Route::get('/ckeckout', [\App\Http\Controllers\BasketController::class, 'checkout'])->name('checkout');
    Route::post('/add/{id}', [\App\Http\Controllers\BasketController::class, 'add'])->name('add');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
