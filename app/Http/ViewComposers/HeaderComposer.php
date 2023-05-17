<?php

namespace App\Http\ViewComposers;

use App\Models\Settings;
use App\Services\BasketService;
use App\Services\FavoriteService;
use Illuminate\View\View;
class HeaderComposer
{
    private FavoriteService $favoriteService;
    private BasketService $basketService;
    public function __construct(FavoriteService $favoriteService, BasketService $basketService)
    {
        $this->favoriteService = $favoriteService;
        $this->basketService = $basketService;
    }

    public function compose(View $view) {
        return $view->with(['favorite', $this->favoriteService->sessionSave(),
                            'basket', $this->basketService->saveSession(),
                            'settings' => Settings::get()->pluck('settings')->first()]);
    }
}
