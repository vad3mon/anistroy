<?php

namespace App\Services;

use App\Models\Basket;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class BasketService
{

    public function getBasket(Request $request)
    {
        $session_id = session()->getId();
        $user_id = !empty($request->user()) ? $request->user()->id : null;

        if (!empty($user_id))
        {
            try {
                $basket = Basket::where('user_id', $user_id)->firstOrFail();
                $basket_id = $basket->id;
            }

            catch (ModelNotFoundException $e)
            {
                $basket = Basket::create();
                $basket->user_id = $user_id;
                $basket->session_id = $session_id;
                session()->put('basket_id', $basket->id);
                $basket->save();
                return $basket;
            }
        }

        else {
            $basket_id = session()->get('basket_id');
        }



        if (!empty($basket_id))
        {
            try {
                $basket = Basket::findOrFail($basket_id);
            }

            catch (ModelNotFoundException $e)
            {
                $basket = Basket::create();
                $basket->session_id = $session_id;
            }

        }
        else {
            $basket = Basket::create();
            $basket->session_id = $session_id;
        }

        $basket->save();
        session()->put('basket_id', $basket->id);
        return $basket;
    }

    public function increase($basketId, $productId, $quantity = 1)
    {
        $this->change($basketId, $productId, $quantity);
    }

    public function decrease($basketId, $productId, $quantity = 1)
    {
        $this->change($basketId, $productId, $quantity * -1);
    }

    public function change($basketId, $productId, $quantity)
    {
        if ($quantity == 0)
        {
            return;
        }

        $basket = Basket::find($basketId);

        if ($basket->products->contains($productId))
        {
            $pivotRow = $basket->products()->where('product_id', $productId)->first()->pivot;
            $count = $pivotRow->quantity + $quantity;
            if ($count > 0)
            {
                $pivotRow->update(['quantity' => $count]);
            }

            else {
                $pivotRow->delete();
            }
        }

        elseif ($quantity > 0) {
            $basket->products()->attach($productId, ['quantity' => $quantity]);
        }

        $basket->touch();
    }

    public function getProduct($basketId, $productId)
    {
        $basket = Basket::find($basketId);

        if ($basket->products->contains($productId))
        {
            return true;
        }

        return false;
    }

    public function getAmount(Basket $basket)
    {
        $amount = 0.0;
        foreach($basket->products as $product)
        {
            $amount = $amount + $product->price * $product->pivot->quantity;
        }

        return $amount;
    }

    public function remove($basket_id, $product_id)
    {
        $basket = Basket::find($basket_id);

        $basket->products()->detach($product_id);

        $basket->touch();
    }

    public function clear($basket_id)
    {
        $basket = Basket::find($basket_id);

        $basket->products()->detach();

        $basket->touch();
    }
}
