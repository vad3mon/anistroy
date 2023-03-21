<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private CategoryService $categoryService;
    private ProductService $productService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function show($currentCategorySlug, $productSlug)
    {

        $currentCategory = $this->categoryService->getCategoryBySlug($currentCategorySlug);

        $product = $this->productService->getProductBySlug($productSlug);



        $categories = $this->categoryService->getChildrenCategories($currentCategory->id);

        $parentCategories = $this->categoryService->getFullPath($product->id);

        return view('catalog.product', compact('product', 'categories', 'parentCategories'));
    }
}
