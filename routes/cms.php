<?php

use App\Http\Controllers\Cms\{CmsDashboardController, CmsModelsController, CmsSettingsController, CmsEditorsController};

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('cms.')
    ->group(function() {


        Route::get('/dashboard/', [CmsDashboardController::class, 'home'])->name('dashboard.home');

        // Действия с админ моделями
        Route::prefix('/edit')
            ->name('models.')
            ->group(function() {
                Route::get('/{module}', [CmsModelsController::class, 'home'])->name('home');

                Route::get('/{module}/{id}', [CmsModelsController::class, 'item'])->name('item');

                Route::post('/{module}/{id}/save', [CmsModelsController::class, 'save'])->name('save');

                Route::post('/{module}/position', [CmsModelsController::class, 'position'])->name('position');

                Route::delete('/{module}/{id}/delete', [CmsModelsController::class, 'delete'])->name('delete');
        });

        // Действия с settings
        Route::prefix('/settings')
            ->name('settings.')
            ->group(function() {
            Route::get('/', [CmsSettingsController::class, 'home'])->name('home');

            Route::post('/save', [CmsSettingsController::class, 'save'])->name('save');
        });

        // Действия с редакторами cms
        Route::prefix('/editors')
            ->name('editors.')
            ->group(function() {
                Route::get('/', [CmsEditorsController::class, 'home'])->name('home');

                Route::get('/{id}', [CmsEditorsController::class, 'item'])->name('item');

                Route::post('/{id}/save', [CmsEditorsController::class, 'save'])->name('save');
                Route::post('/{id}/delete', [CmsEditorsController::class, 'delete'])->name('delete');

        });


});
