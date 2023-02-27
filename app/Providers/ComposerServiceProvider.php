<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Services\PageService;
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

        View::composer('pages.top_pages', function($view) {
            $view->with(['items' => Page::getTopPages()]);
//            $view->with(['items' => [PageService::class, 'getTopPages']]);
        });

    }
}
