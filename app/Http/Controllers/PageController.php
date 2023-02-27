<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\CategoryService;
use App\Services\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private CategoryService $categoryService;
    private PageService $pageService;

    public function __construct(CategoryService $categoryService, PageService $pageService)
    {
        $this->categoryService = $categoryService;
        $this->pageService = $pageService;
    }

    public function index($slug)
    {
        $page = $this->pageService->getPageBySlug($slug);

        $categories = $this->categoryService->getAllCategories();

        return view('pages.index', compact('categories', 'page'));
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
