<?php

namespace App\Services;

use App\Mail\OrderMailer;
use App\Models\Basket;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BasketService
{
    public function basketUnion($userBasket)
    {
        if (session()->get('basket_id'))
        {
            $sessionBasket = self::getSessionBasket(session()->get('basket_id'));
            foreach($sessionBasket->products as $product)
            {
                $userBasket->products()->attach($product->id, ['quantity' => $product->pivot->quantity]);
            }
        }
    }
    public function getUserBasket()
    {
        $session_id = session()->getId();
//        $user_id = !empty($request->user()) ? $request->user()->id : null;

        $user_id = Auth::check() ? Auth()->user()->id : null;

        if (!empty($user_id))
        {
            try {
                $basket = Basket::where('user_id', $user_id)->firstOrFail();
                $basket_id = $basket->id;

                if ($basket_id != session()->get('basket_id'))
                {
                    $this->basketUnion($basket);
                }



            }

            catch (ModelNotFoundException $e)
            {
                $basket = Basket::create();
                $basket->user_id = $user_id;
                $basket->session_id = $session_id;
                self::basketUnion($basket);
                session()->put('basket_id', $basket->id);
                $basket->save();
                return $basket;
            }
        }

        else {
            $basket_id = session()->get('basket_id');
            $basket = self::getSessionBasket($basket_id);
            return $basket;
        }

        $basket->save();
        session()->put('basket_id', $basket_id);
//        dd($basket_id !== session()->get('basket_id'));
//        dd(session()->get('basket_id') == $basket_id);
//        dd($basket->products);
        return $basket;


    }

    public function getSessionBasket($basket_id)
    {
        $session_id = session()->getId();
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

    public function getBasket()
    {
        $basket = self::getUserBasket();
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

        $this->saveSession();
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

        $this->saveSession();
    }

    public function clear($basket_id)
    {
        $basket = Basket::find($basket_id);

        $basket->products()->detach();

        $basket->touch();

        $this->saveSession();
    }

    public function saveSession()
    {
        $inCart = $this->getBasket();

        session()->put('inCart', $inCart->products->pluck('id'));
    }

    public function saveOrder($request)
    {
        $basket = $this->getBasket();

        $user_id = !empty($request->user()) ? $request->user()->id : null;
        $session_id = empty($user_id) ? session()->getId() : null;

        $order = Order::create($request->all() + ['amount' => $this->getAmount($basket),
                'user_id' => $user_id,
                'session_id' => $session_id]);

        $order->save();

        $mailData = [
            'id' => $order->id,
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'date' => $order->created_at->format('d.m.Y'),
            'status' => 'Ожидает оплаты',
            'payment_status' => 'Ожидает оплаты',
            'amount' => $this->getAmount($basket),
            'comment' => $request['comment']
        ];

        foreach ($basket->products as $product) {
            $order->items()->create([
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'cost' => $product->price * $product->pivot->quantity,
            ]);

            $mailData['products'][] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'cost' => $product->price * $product->pivot->quantity,
                'image' => $product->image
            ];
        }

        $this->clear($basket->id);

        try {
            Mail::to($request['email'])->send(new OrderMailer($mailData));
        }

        catch (\Exception $e)
        {
            Log::channel('maillog')->error('Error with sending order mail', [
                date('Y-m-d H:i:s') => [
                    'Ошибка отправки почты',
                    $order->id,
                    $request['email'],
                    $request['name'],
                    $request['phone'],
                    $request['address'],
                    $request['comment'],
                    'products' => $mailData['products']
                ]
            ]);
        }


        return $order;
    }
}
