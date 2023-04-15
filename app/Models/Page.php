<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public static function getTopPages()
    {
        return self::where('binding', 'header')->orWhere('binding', 'header_footer')->get();
    }

    public static function getFooterPages()
    {
        return (self::whereNull('parent_id'))->whereIn('binding', ['footer', 'header_footer'])->with('childrens')->get();
    }

    public function childrens()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }
}
