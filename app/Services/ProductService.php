<?php

namespace App\Services;

use App\Models\Product;


use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ProductService
{
    public function getProductBySlug($slug)
    {
        $product = Product::where('slug', $slug)->with('properties')->first();

        return $product;
    }

    public function getParentCategories($id)
    {
        $category = Product::find($id)->categories->first();

        return $category;
    }



}
