<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'ms_id',
        'category_id',
        'name',
        'slug',
        'article',
        'image',
        'text',
        'price',
        'unit',
        'weight',
        'volume'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function baskets()
    {
        return $this->belongsToMany(Basket::class)->withPivot('quantity');
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function scopeFiltered(Builder $query)
    {
        $query->when(request('filters.price'), function (Builder $q) {
            $q->whereBetween('price', [
                request('filters.price.from', 0),
                request('filters.price.to', 120000)
            ]);
        })
            ->when(request('filters.properties'), function (Builder $q) {
                foreach(request('filters.properties') as $id => $value)
                {
                    $q->whereHas('properties', function (Builder $query) use ($id, $value) {
                        $query->where('property_id','=', $id)
                                ->whereIn('value', $value);
                    });
                }

//                $q->whereRelation([['properties', 'property_id', '=', 1], ['properties', 'value', 'Китай']]);

            })

            ->when(request('filters.range'), function (Builder $q) {
                foreach(request('filters.range') as $id => $value)
                {
                    $q->whereHas('properties', function (Builder $query) use ($id, $value) {
                        $query->where('property_id','=', $id)
                            ->whereBetween('value', [
                                (int)$value['from'],
                                (int)$value['to']
                            ]);
                    });
                }
            });
    }


    /**
     * Позволяет выбирать товары категории и всех ее потомков
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategoryProducts(Builder $builder, $id) {
        $descendants = Category::getAllChildren($id)->pluck('id');
        $descendants[] = $id;

        return $builder->whereIn('category_id', $descendants);
    }
}
