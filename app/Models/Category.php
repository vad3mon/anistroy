<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }

    public static function all_categories()
    {
        return self::whereNull('parent_id')
            ->with('childrenCategories')
            ->get();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function all_products()
    {
        $products = []; //массив продуктов всех дочерних категорий
        $categories = [$this];

        while (count($categories) > 0)
        {
            $nextCategories = []; //дочерние категории
            foreach ($categories as $category) {
                if ($category->products->count())
                {
                    foreach ($category->products as $childProducts)
                    {
                        $products = array_merge($products, [$childProducts]); //добавляет в массив дочернии продукты
                    }
                }

                $nextCategories = array_merge($nextCategories, [$category->categories()->with('products')->get()]);
            }

            $categories = $nextCategories[0];
        }
//dd(collect($products));
        return collect($products);
    }
}
