<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        $discountProducts = $this->categoryService->getDiscountProducts();

        $bannerProducts = $this->categoryService->getBannerProducts();

        return view('index', compact('categories', 'discountProducts', 'bannerProducts'));
    }

    public function category(Category $category)
    {
//        \DB::connection()->enableQueryLog();

        $currentCategory = $this->categoryService->getCategory($category->id);

        $properties = $this->categoryService->getCategoryProperties($currentCategory);

        $categories = $this->categoryService->getChildrenCategories($category->id);

        $products = $this->categoryService->getCategoryProducts($category->id);

        $fullPath = $this->categoryService->getFullPath($category->id);

//        dd( \DB::getQueryLog());

        return view('catalog.category', compact('categories', 'products', 'currentCategory', 'properties', 'fullPath'));
    }

    public function search(Request $request)
    {
        $products = $this->categoryService->search($request->input('query'));

        $categories = $this->categoryService->getAllCategories();

        return view('catalog.search', compact('categories', 'products'));
    }
}
