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

        $products = $this->categoryService->getDiscountProducts();

        $bannerProduct = $this->categoryService->getBannerProduct();

        return view('index', compact('categories', 'products', 'bannerProduct'));
    }

    public function category(Category $category)
    {
        $currentCategory = $this->categoryService->getCategory($category->id);

        $properties = $this->categoryService->getCategoryProperties($currentCategory->id);

        $categories = $this->categoryService->getChildrenCategories($category->id);

        $products = $this->categoryService->getCategoryProducts($category->id);

        return view('catalog.category', compact('categories', 'products', 'currentCategory', 'properties'));
    }

    public function search(Request $request)
    {
        $products = $this->categoryService->search($request['query']);

        $products  = $this->categoryService->paginate($products, 20);

        $categories = $this->categoryService->getAllCategories();

        return view('catalog.search', compact('categories', 'products'));
    }
}
