<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->with('childrenCategories')
            ->get();

        return view('layout.site', compact('categories'));
    }

    public function category(Category $category)
    {
        $category = Category::find($category->id);

        $categories = Category::find($category->id)->childrenCategories;

        $products = Category::find($category->id)->all_products();

//        dd($products);
        return view('catalog.category', compact('categories', 'products', 'category'));
    }
}
