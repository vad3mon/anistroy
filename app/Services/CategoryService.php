<?php

namespace App\Services;

use App\Models\BannerProducts;
use App\Models\Category;
use App\Models\DiscountProducts;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use function PHPUnit\Framework\isNull;

class CategoryService
{
    public function getAllCategories()
    {
        $categories = Category::whereNull('parent_id')
            ->with('childrenCategories')
            ->orderBy('name')
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
        $categories = count($category->childrenCategories) > 1 ? $category->childrenCategories : $category->parent->childrenCategories;

        return $categories->sortBy('name');
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

    public function getFullPath($category_id)
    {
        $category = Category::find($category_id);
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
        $products = [];
        $discountProducts = DiscountProducts::where('published', 1)->orderBy('position')->get();
        foreach ($discountProducts as $discountProduct)
        {
            if ($discountProduct->product->category_id)
            {
                $products[] = $discountProduct->product;
            }
        }

        return $products;
    }

    public function getBannerProducts()
    {
        $products = [];
        $bannerProducts = BannerProducts::where('published', 1)->orderBy('position')->get();
        foreach ($bannerProducts as $bannerProduct)
        {
            if ($bannerProduct->product->category_id)
            {
                $products[] = $bannerProduct->product;
            }
        }

        return $products;
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
        $products = Product::whereNotNull('category_id')
                             ->where(function ($q) use ($query)
                             {
                                 $q->where('name', 'like', '%' . $query . '%')
                                     ->orWhere('article', 'like', '%' . $query . '%')
                                     ->orWhere('slug', 'like', '%' . $query . '%');
//                                     ->orWhere('text', 'like', '%' . $query . '%')
                             })->distinct()->with('category')->paginate(20)->withQueryString();

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

//    функция округления до сотого числа (если вдруг шаг будет не 1)
    function round_up($num, $precision) {
        $num = $num / pow(10, $precision);
        $num = ceil($num);
        return $num * pow(10, $precision);
    }

    public function getCategoryPriceProperty($category)
    {
        $products = array_unique(Product::categoryProducts($category->id)
//          ->filtered()
            ->get('price')->pluck('price')->toArray());

        $property =  collect([
            'title' => 'Цена',
            'type' => 'price',
            'values' => collect([
                'min' => count($products) ? floor(min($products)) : 0,
                'max' => count($products) ? ceil(max($products)) : 0,
                'step' => 1
            ])
        ]);

        return $property;
    }

    public function getCategoryProperties($category)
    {
        $curCat = $category;
        $properties = collect();

        $ids = collect();
        $ids = Category::getAllChildren($category->id)->pluck('id');
        $ids->push($category->id);

        $categories = Category::whereIn('id', $ids)->with(['properties', 'properties.values' => function ($query) use ($ids) {
            $query->select('category_id', 'value')->whereIn('category_id', $ids);
        }])->get();


        foreach ($categories as $category)
        {
            if ($category->has('properties'))

            {
                foreach ($category->properties as $property) {
                    if ($properties->contains('id', $property->id))
                    {
                        $curProp = $properties->where('id', $property->id)->first();
                        $values = $property->type == 'list' ? $this->getUniquePivotValues($category->id, $property->values) : $this->getMinMaxPivotValues($category->id, $property->values);
                        $curProp['values'] = ($curProp['values']->merge($values))->unique();
                    }

                    else {
                        $values = $property->type == 'list' ? $this->getUniquePivotValues($category->id, $property->values) : $this->getMinMaxPivotValues($category->id, $property->values);
                        $properties->add(
                            collect([
                                'id' => $property->id,
                                'title' => $property->title,
                                'type' => $property->type,
                                'values' => $values
                            ]));

                    }


                }
            }
        }

        $properties->each(function ($property) {
            $sorted = $property['values']->sortBy(null, SORT_NATURAL)->sortBy(function ($value) {
                return (float) preg_replace('/[^\d\.]/', '', str_replace(',', '.', $value));
            });

            $property['values'] = $sorted;
        });

        $properties->sortBy('title');
        $properties->add($this->getCategoryPriceProperty($curCat));
        return $properties;
    }

    public function getUniquePivotValues($category_id, $values) {
        $pivots = [];
        foreach ($values as $value)
        {
            if ($value->category_id == $category_id) {
                $pivots[] = $value->pivot->value;
            }
        }

        $pivots = array_unique($pivots);

        return collect($pivots);
    }

    public function getMinMaxPivotValues($category_id, $values) {
        $pivots = [];
        foreach ($values as $value)
        {
            if ($value->category_id == $category_id)
                $pivots[] = (float) preg_replace('/[^\d\.]/', '', str_replace(',', '.', $value->pivot->value));
        }

        $pivots = array_unique($pivots);

        return collect([
            'min' => floor(min($pivots)),
            'max' => ceil(max($pivots))
        ]);
    }

}
