<?php

namespace App\Services;

use App\Models\Basket;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cookie;

class BasketService
{
    public function getBasket()
    {
        $basket_id = (int)request()->cookie('basket_id');
        if (!empty($basket_id))
        {

            try {
                $basket = Basket::findOrFail($basket_id);
            }

            catch (ModelNotFoundException $e)
            {
                $basket = Basket::create();
            }

        }
        else {
            $basket = Basket::create();
        }

        Cookie::queue('basket_id', $basket->id, 525600);
        return $basket;
    }

    public function increase($basketId, $productId, $quantity)
    {
        $this->change($basketId, $productId, $quantity);
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
}
