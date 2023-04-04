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

Route::get('/sync_product_folder', [\App\Http\Controllers\SyncController::class, 'sync_product_folder']);
Route::get('/sync_products', [\App\Http\Controllers\SyncController::class, 'sync_products']);
Route::get('/sync_orders', [\App\Http\Controllers\SyncController::class, 'sync_orders']);

Route::get('/', [\App\Http\Controllers\CatalogController::class, 'index'])->name('index');

Route::get('/agreement', [\App\Http\Controllers\PageController::class, 'agreement'])->name('agreement');
Route::get('/address', [\App\Http\Controllers\PageController::class, 'address'])->name('address');
Route::get('/bonus', [\App\Http\Controllers\PageController::class, 'bonus'])->name('bonus');

Route::group([
    'as' => 'pages.',
    'prefix' => 'pages',
], function() {
    Route::get('/{page:slug}', [\App\Http\Controllers\PageController::class, 'index'])->name('index');
});


Route::get('/order/{session_id}/{order_id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('getOrder');

Route::group([
    'as' => 'catalog.',
    'prefix' => 'catalog',
], function() {
    Route::get('/{category:slug}', [\App\Http\Controllers\CatalogController::class, 'category'])->name('category');
    Route::get('/{category:slug}/{product:slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product');
    Route::post('/search', [\App\Http\Controllers\CatalogController::class, 'search'])->name('search');;
});


Route::group([
    'as' => 'basket.',
    'prefix' => 'basket',
], function() {
    Route::get('/index', [\App\Http\Controllers\BasketController::class, 'index'])->name('index');
    Route::post('/add/{id}', [\App\Http\Controllers\BasketController::class, 'add'])->name('add');
    Route::post('/plus/{id}', [\App\Http\Controllers\BasketController::class, 'plus'])->name('plus');
    Route::post('/minus/{id}', [\App\Http\Controllers\BasketController::class, 'minus'])->name('minus');
    Route::post('/remove/{id}', [\App\Http\Controllers\BasketController::class, 'remove'])->name('remove');
    Route::post('/saveorder', [\App\Http\Controllers\BasketController::class, 'saveOrder'])->name('saveorder');

});

Route::group([
    'as' => 'favorite.',
    'prefix' => 'favorite',
], function() {
    Route::get('/index', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('index');
    Route::post('/add/{id}', [\App\Http\Controllers\FavoriteController::class, 'add'])->name('add');
    Route::post('/remove/{id}', [\App\Http\Controllers\FavoriteController::class, 'remove'])->name('remove');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/change_password', [ProfileController::class, 'change_password'])->name('profile.change_password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('profile.orders');
});

require __DIR__.'/auth.php';
