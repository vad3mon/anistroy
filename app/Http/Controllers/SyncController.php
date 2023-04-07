<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MCsync;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\SyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SyncController extends Controller
{
    private SyncService $syncService;

    public function __construct(SyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    public function sync_product_folder()
    {
        $this->syncService->sync_product_folder();
    }

    public function sync_products()
    {
        $this->syncService->sync_products();
    }

    function sync_orders()
    {
        $this->syncService->sync_orders();
    }

    function clean()
    {
        $this->syncService->clean_products(3);
    }

    function sync_counterparty()
    {
        $this->syncService->sync_counterparty();
    }

}
