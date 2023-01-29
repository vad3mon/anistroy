<?php

namespace App\Http\Controllers;

use App\Services\BasketService;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    private CategoryService $categoryService;
    private ProductService $productService;
    private BasketService $basketService;
    private $basket;

    public function __construct(ProductService $productService, CategoryService $categoryService, BasketService $basketService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->basketService = $basketService;

    }


    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        $basket = $this->basketService->getBasket();
        $products = $basket->products;
//        dd($products);
        return view('basket.index', compact('categories', 'products'));
    }

    public function checkout()
    {
        return view('basket.checkout');
    }

    public function add(Request $request, $id)
    {
        $quantity = $request['quantity'] ?? 1;
        $basket = $this->basketService->getBasket();

        if ($this->basketService->getProduct($basket->id, $id)) {
            $categories = $this->categoryService->getAllCategories();
            $products = $basket->products;
            return view('basket.index', compact('categories', 'products'));
        }

        $this->basketService->increase($basket->id, $id, $quantity);

        return back();
    }

}
