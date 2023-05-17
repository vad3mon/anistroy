<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'published',
        'binding',
        'name',
        'slug',
        'content',
    ];

    public static function getTopPages()
    {
        return self::whereIn('binding', ['header', 'header_footer'])->where('published', 1)->get();
    }

    public static function getFooterPages()
    {
        return (self::whereNull('parent_id'))->whereIn('binding', ['footer', 'header_footer'])->where('published', 1)->with([
            'childrens' => function ($query) {
                $query->whereIn('binding', ['footer', 'header_footer'])->where('published', 1);
            }
        ])->get();
    }

    public function childrens()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }
}
