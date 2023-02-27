<?php

namespace App\Services;

use App\Models\Page;

class PageService
{
    public function getPageBySlug($slug)
    {
        $page = Page::where('slug', $slug)->first();

        return $page;
    }

    public static function getTopPages()
    {
        return Page::where('binding', 'top')->get();
    }
}
