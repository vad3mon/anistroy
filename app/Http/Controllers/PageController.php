<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function agreement()
    {
        $categories = $this->categoryService->getAllCategories();

        return view('pages.agreement', compact('categories'));
    }

    public function address()
    {
        $categories = $this->categoryService->getAllCategories();

        return view('pages.address', compact('categories'));
    }

    public function bonus()
    {
        $categories = $this->categoryService->getAllCategories();

        return view('pages.bonus', compact('categories'));
    }

}
