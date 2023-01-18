<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('catalog.burger', function($view) {
            $view->with(['items' => Category::all_categories()]);
        });
    }
}
