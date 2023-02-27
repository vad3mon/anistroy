<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FavoriteService
{
    public function favoriteUnion($userFavorite)
    {
        if (session()->get('favorite_id'))
        {
            $sessionFavorite = self::getSessionFavorite(session()->get('favorite_id'));
            foreach($sessionFavorite->products as $product)
            {
                $userFavorite->products()->attach($product->id);
            }
        }
    }
    public function getUserFavorite(Request $request)
    {
        $session_id = session()->getId();
        $user_id = !empty($request->user()) ? $request->user()->id : null;

        if (!empty($user_id))
        {
            try {
                $favorite = Favorite::where('user_id', $user_id)->firstOrFail();
                $favorite_id = $favorite->id;

                if ($favorite_id != session()->get('favorite_id'))
                {
                    $this->favoriteUnion($favorite);
                }



            }

            catch (ModelNotFoundException $e)
            {
                $favorite = Favorite::create();
                $favorite->user_id = $user_id;
                $favorite->session_id = $session_id;
                self::favoriteUnion($favorite);
                session()->put('favorite_id', $favorite->id);
                $favorite->save();
                return $favorite;
            }
        }

        else {
            $favorite_id = session()->get('favorite_id');
            $favorite = self::getSessionFavorite($favorite_id);
            return $favorite;
        }

        $favorite->save();
        session()->put('favorite_id', $favorite_id);
//        dd($basket_id !== session()->get('basket_id'));
//        dd(session()->get('basket_id') == $basket_id);
//        dd($basket->products);
        return $favorite;


    }

    public function getSessionFavorite($favorite_id)
    {
        $session_id = session()->getId();
        if (!empty($favorite_id))
        {
            try {
                $favorite = Favorite::findOrFail($favorite_id);
            }

            catch (ModelNotFoundException $e)
            {
                $favorite = Favorite::create();
                $favorite->session_id = $session_id;
            }

        }
        else {
            $favorite = Favorite::create();
            $favorite->session_id = $session_id;
        }

        $favorite->save();
        session()->put('favorite_id', $favorite->id);
        return $favorite;
    }

    public function addProduct($favorite_id, $product_id)
    {
        $favorite = Favorite::find($favorite_id);

        if (!$favorite->products->contains($product_id))
        {
            $favorite->products()->attach($product_id);
        }

        $favorite->touch();

        return $favorite;
    }
    public function getFavorite(Request $request)
    {
        $favorite = self::getUserFavorite($request);
        return $favorite;
    }

    public function remove($favorite_id, $product_id)
    {
        $favorite = Favorite::find($favorite_id);

        $favorite->products()->detach($product_id);

        $favorite->touch();
    }

    public function clear($favorite_id)
    {
        $favorite = Basket::find($favorite_id);

        $favorite->products()->detach();

        $favorite->touch();
    }

    public function getProduct($favoriteId, $productId)
    {
        $favorite = Favorite::find($favoriteId);

        if ($favorite->products->contains($productId))
        {
            return true;
        }

        return false;
    }
}
