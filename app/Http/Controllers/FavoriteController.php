<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Services\FavoriteService;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    private CategoryService $categoryService;
    private ProductService $productService;
    private FavoriteService $favoriteService;


    public function __construct(ProductService $productService, CategoryService $categoryService, FavoriteService $favoriteService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->favoriteService = $favoriteService;
    }


    public function index(Request $request)
    {
        $favorite = $this->favoriteService->getFavorite($request);
        $categories = $this->categoryService->getAllCategories();
        $products = $favorite->products;

        return view('favorite.index', compact('categories', 'products'));
    }

    public function add(Request $request, $id)
    {
        $favorite = $this->favoriteService->getFavorite($request);

            if ($this->favoriteService->getProduct($favorite->id, $id)) {
                $this->favoriteService->remove($favorite->id, $id);
                return back();
            }

        $categories = $this->categoryService->getAllCategories();
        $this->favoriteService->addProduct($favorite->id, $id);
        $products = $favorite->products;
        return view('favorite.index', compact('categories', 'products'));
    }

    public function remove(Request $request, $product_id)
    {
        $favorite = $this->favoriteService->getFavorite($request);
        $this->favoriteService->remove($favorite->id, $product_id);

        return redirect()->route('favorite.index');
    }

}
