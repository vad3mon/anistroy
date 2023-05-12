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
        'slug',
        'ms_id'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('name');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with(['categories'])->orderBy('name');
    }

    public static function all_categories()
    {
        return self::whereNull('parent_id')
            ->with('childrenCategories')
            ->orderBy('name')
            ->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

    public static function getAllChildren($id) {
        $children = self::where('parent_id', $id)->with('categories')->get();
        $categories = [];

        foreach ($children as $child) {
            $categories[] = $child;
            if ($child->categories->count()) {
                $categories = array_merge($categories, self::getAllChildren($child->id)->toArray());
            }
        }

        return collect($categories);
    }
}
