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
        $categories = Category::find($category->id)->childrenCategories;
        return view('layout.site', compact('categories'));
    }
}
