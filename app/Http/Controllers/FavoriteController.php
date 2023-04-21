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


    public function index()
    {
        $favorite = $this->favoriteService->getFavorite();
        $categories = $this->categoryService->getAllCategories();
        $products = $favorite->products;

        return view('favorite.index', compact('categories', 'products'));
    }

    public function add($id)
    {
        $favorite = $this->favoriteService->getFavorite();

        if ($this->favoriteService->getProduct($favorite->id, $id)) {
            $this->favoriteService->remove($favorite->id, $id);
            return back();
        }

        else
        {
            $this->favoriteService->addProduct($favorite->id, $id);
            return back();
        }

    }

    public function remove($product_id)
    {
        $favorite = $this->favoriteService->getFavorite();
        $this->favoriteService->remove($favorite->id, $product_id);

        return redirect()->route('favorite.index');
    }

}
