<?php

namespace App\Providers;

use App\Http\ViewComposers\HeaderComposer;
use App\Models\Category;
use App\Models\Page;
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
        });

        View::composer('pages.footer_pages', function($view) {
            $view->with(['items' => Page::getFooterPages()]);
        });

        View::composer('layout.site', HeaderComposer::class);

    }
}
