<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public static function getTopPages()
    {
        return self::where('binding', 'top')->orWhere('binding', 'top_footer')->get();
    }

    public static function getFooterPages()
    {
        return self::where('binding', 'footer')->orWhere('binding', 'top_footer')->get();
    }
}
