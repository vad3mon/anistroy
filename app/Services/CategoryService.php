<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CategoryService
{
    public function getAllCategories()
    {
        $categories = Category::whereNull('parent_id')
            ->with('childrenCategories')
            ->get();

        return $categories;
    }

    public function getCategory($id)
    {
        $category = Category::find($id);

        return $category;
    }

    public function getChildrenCategories($id)
    {
        $category = Category::find($id);
        $categories = $category->childrenCategories;

        return $categories;
    }

    public function getProducts($id)
    {
        $products = []; //массив продуктов всех дочерних категорий
        $categories = [Category::find($id)];

        while (count($categories) > 0)
        {
            $nextCategories = []; //дочерние категории
            foreach ($categories as $category) {
                if ($category->products->count())
                {
                    foreach ($category->products as $childProducts)
                    {
                        $products = array_unique(array_merge($products, [$childProducts])); //добавляет в массив дочернии продукты
//                        $products[] = [$childProducts];
                    }
                }

                $nextCategories = array_merge($nextCategories, [$category->categories()->with('products')->get()]);
            }

            $categories = $nextCategories[0];
        }
        return collect($products);
    }

    public function getFullPath($product_id)
    {
        $product = Product::find($product_id);
        $category = $product->category;
        $parentCategories = [$category];
        while ($category->parent)
        {
            $parent = $category->parent;

            $parentCategories = array_merge($parentCategories, [$parent]);

            $category = $category->parent;
        }


        return collect(array_reverse($parentCategories));

    }

    public function getCategoryBySlug($slug)
    {
        $category = Category::where('slug', $slug)->first();

        return $category;
    }

    public function getDiscountProducts()
    {
        $products = Product::find([529, 510, 530, 504, 1500, 1525, 2504, 3809]);
        return $products;
    }

    public function getBannerProduct()
    {
        $bannerProduct = Product::find(529);
        return $bannerProduct;
    }


    public static function paginate(Collection $results, $pageSize)
    {
        $page = Paginator::resolveCurrentPage('page');

        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }

    public function search($query)
    {
        $query = trim($query);
        $products = Product::where('name', 'like', '%' . $query . '%')
                             ->orWhere('article', 'like', '%' . $query . '%')
                             ->orWhere('slug', 'like', '%' . $query . '%')
                             ->orWhere('text', 'like', '%' . $query . '%')->distinct()->with('category')->get();

        return $products;
    }

    public static function getAllChildren($id) {
        $children = self::where('parent_id', $id)->with('categories')->get();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child->id;
            // для каждого прямого потомка получаем его прямых потомков
            if ($child->children->count()) {
                $ids = array_merge($ids, self::getAllChildren($child->id));
            }
        }
        return $ids;
    }

    public function getCategoryProducts($category_id)
    {
        $products = Product::categoryProducts($category_id)
                ->filtered()
                ->paginate(20)
                ->withQueryString();

        return $products;
    }
}
