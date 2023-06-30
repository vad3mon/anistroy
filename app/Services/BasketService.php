<?php

namespace App\Services;

use App\Mail\OrderMailer;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Transport;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use Yandex\Geocode\Facades\YandexGeocodeFacade;

class BasketService
{
    public function basketUnion($userBasket)
    {
        if (session()->get('basket_id')) {
            $sessionBasket = self::getSessionBasket(session()->get('basket_id'));
            foreach ($sessionBasket->products as $product) {
                $userBasket->products()->attach($product->id, ['quantity' => $product->pivot->quantity]);
            }
        }
    }

    public function getUserBasket()
    {
        $session_id = session()->getId();
//        $user_id = !empty($request->user()) ? $request->user()->id : null;

        $user_id = Auth::check() ? Auth()->user()->id : null;

        if (!empty($user_id)) {
            try {
                $basket = Basket::where('user_id', $user_id)->firstOrFail();
                $basket_id = $basket->id;

                if ($basket_id != session()->get('basket_id')) {
                    $this->basketUnion($basket);
                }


            } catch (ModelNotFoundException $e) {
                $basket = Basket::create();
                $basket->user_id = $user_id;
                $basket->session_id = $session_id;
                self::basketUnion($basket);
                session()->put('basket_id', $basket->id);
                $basket->save();
                return $basket;
            }
        } else {
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
        if (!empty($basket_id)) {
            try {
                $basket = Basket::findOrFail($basket_id);
            } catch (ModelNotFoundException $e) {
                $basket = Basket::create();
                $basket->session_id = $session_id;
            }

        } else {
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
        if ($quantity == 0) {
            return;
        }

        $basket = Basket::find($basketId);

        if ($basket->products->contains($productId)) {
            $pivotRow = $basket->products()->where('product_id', $productId)->first()->pivot;
            $count = $pivotRow->quantity + $quantity;
            if ($count > 0) {
                $pivotRow->update(['quantity' => $count]);
            } else {
                $pivotRow->delete();
            }
        } elseif ($quantity > 0) {
            $basket->products()->attach($productId, ['quantity' => $quantity]);
        }

        $basket->touch();

        $this->saveSession();
    }

    public function getProduct($basketId, $productId)
    {
        $basket = Basket::find($basketId);

        if ($basket->products->contains($productId)) {
            return true;
        }

        return false;
    }

    public function getAmount(Basket $basket)
    {
        $amount = 0.0;
        foreach ($basket->products as $product) {
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

        $products = $basket->products;

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

        foreach ($products as $product) {
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
                'unit' => $product->unit,
                'quantity' => $product->pivot->quantity,
                'cost' => $product->price * $product->pivot->quantity,
                'image' => $product->image
            ];
        }

        $this->clear($basket->id);

        Mail::to($request['email'])->send(new OrderMailer($order));

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

    public function saveNewOrder($request)
    {

//        return $request->all();
        $basket = $this->getBasket();

        $user_id = !empty($request->user()) ? $request->user()->id : null;
        $session_id = empty($user_id) ? session()->getId() : null;

        $order = Order::create($request->all() + ['amount' => $this->getAmount($basket),
                'user_id' => $user_id,
                'session_id' => $session_id]);

        $order->save();

//        $mailData = [
//            'id' => $order->id,
//            'name' => $request['name'],
//            'email' => $request['email'],
//            'phone' => $request['phone'],
//            'address' => $request['address'],
//            'date' => $order->created_at->format('d.m.Y'),
//            'status' => 'Ожидает оплаты',
//            'payment_status' => 'Ожидает оплаты',
//            'amount' => $this->getAmount($basket),
//            'comment' => $request['comment']
//        ];

        foreach ($basket->products as $product) {
            $order->items()->create([
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'cost' => $product->price * $product->pivot->quantity,
            ]);

//            $mailData['products'][] = [
//                'name' => $product->name,
//                'price' => $product->price,
//                'unit' => $product->unit,
//                'quantity' => $product->pivot->quantity,
//                'cost' => $product->price * $product->pivot->quantity,
//                'image' => $product->image
//            ];
        }

//        $this->clear($basket->id);

//        try {
//            $dadata = DaDataAddress::standardization($request->address);
//            YandexGeocodeFacade::make()->setQuery('Украина, Киев')->load();
//
//        } catch (\Exception $e) {
//            dd($e->getMessage());
//        }


//        try {
//            Mail::to($request['email'])->send(new OrderMailer($mailData));
//        }
//
//        catch (\Exception $e)
//        {
//            Log::channel('maillog')->error('Error with sending order mail', [
//                date('Y-m-d H:i:s') => [
//                    'Ошибка отправки почты',
//                    $order->id,
//                    $request['email'],
//                    $request['name'],
//                    $request['phone'],
//                    $request['address'],
//                    $request['comment'],
//                    'products' => $mailData['products']
//                ]
//            ]);
//        }


        return $order;
    }

    public function getDeliveryPrice($request)
    {
        $movers = config('cms')['settings']['block_3']['fields'];

        $delivery = config('delivery');

        $duration = $request['duration']['value'] / 60; //в минутах

        $products = $this->getBasket()->products->where('price', ">", 0);

        if (!$products->count())
        {
            return ['Нет товаров'];
        }

        $sumWeight = $products->sum('weight');

        $sumVolume = $products->sum('volume');

        $maxLength = max($products->pluck('length')->toArray());


        $transportationPrice = 0;
        $unloadPrice = 0;
        $liftPrice = 0;


        //поиск транспорта подходящего по параметрам
        $transports = Transport::query();

        if ($request['inTTK']) {
            $transports->where('ttk_pass', true);
        }

        if ($request['manipulator']) {
            $transports->where('manipulator', true);
        }


        $transports = $transports->orderBy('max_length', 'desc')->get();

        $returnTransport = Transport::where('documents_return', true)->first();





        //отбор необходимого транспорта

        $needTransport = [];
        $leftWeight = $sumWeight;
        $leftVolume = $sumVolume;

        foreach ($transports as $transport) {
            if ($transport->max_length <= $maxLength && count($needTransport) == 0) {
                if ($transport->capacity >= $leftWeight && $transport->volume >= $leftVolume)
                {
                    $needTransport[] = $transport;
                    break;
                }

                else {
                    if ($leftWeight - $transport->capacity > 0)
                    {
                     $leftWeight -= $transport->capacity;
                    }

                    if ($leftVolume - $transport->capacity > 0)
                    {
                        $leftVolume -= $transport->volume;
                    }

                    $needTransport[] = $transport;
                }
            }

            else {
                if ($transport->capacity >= $leftWeight && $transport->volume >= $leftVolume)
                {
                    $needTransport[] = $transport;
                    break;
                }

                else {
                    if ($leftWeight - $transport->capacity > 0)
                    {
                        $leftWeight -= $transport->capacity;
                    }

                    if ($leftVolume - $transport->capacity > 0)
                    {
                        $leftVolume -= $transport->volume;
                    }

                    $needTransport[] = $transport;
                }
            }
        }


        //сумма стоимости перевозки для всех необходимых транспортов
        foreach($needTransport as $transport)
        {
            $transportationPrice += max($duration + $delivery['unloading_time'], $transport['min_order_time']) *
                ($transport['cost_per_hour'] / 60);

            if ($request['toMkadDistance'])
            {
                $transportationPrice += $request['toMkadDistance']['value'] * $transport['cost_outside_mkad'] / 1000;
            }

        }

        //расчет возврата документов
        if ($duration + $delivery['unloading_time'] > $needTransport[0]['min_order_time'])
        {
            $transportationPrice += ($duration - max(0, $needTransport[0]['min_order_time'] - ($duration + $delivery['unloading_time']))) * $returnTransport['cost_per_hour'] / 60;

            if ($request['toMkadDistance'])
            {
                $transportationPrice += $request['toMkadDistance']['value'] * $returnTransport['cost_outside_mkad'] / 1000;
            }
        }




        //расчет разгрузки и подьема на этаж
        if ($request['lift'] || $request['unload'])
        {

            //если не отмечен пронос свыше 25м
            if (!$request['overCarry'])
            {
                $unloadPrice = (ceil($sumWeight) / 100) * $movers['loader_base']['value'];
            }

            else {
                if ($request['overCarryValue'])
                {
                    $unloadPrice = (ceil($sumWeight) / 100) * $movers['loader_base']['value'] + ceil(((int)$request['overCarryValue'] - 25) / 20) * $sumWeight * $movers['loader_more_carry']['value'];
                }
            }


            if ($request['cleaning'])
            {
                $unloadPrice += $movers['loader_cleaning']['value'];
            }


            //если выбран пассажирский лифт
            if ($request['opt'] == "1")
            {
                $overWeight = 0;

                //расчет массы не влезающих товаров
                foreach ($products as $product)
                {
                    if (($product->width > $delivery['elevator_size']['width']) || ($product->length > $delivery['elevator_size']['length']))
                    {
                        $overWeight += $product->weight;
                    }
                }

                //расчет подьема на этаж
                if ($request['floor'])
                {
                    $liftPrice = ceil($overWeight /100) * $request['floor'] * $movers['loader_lift']['value'];
                }

                //расчет на технический этаж
                if ($request['techFloor'])
                {
                    $liftPrice += ceil($sumWeight / 100) * $movers['loader_lift']['value'];
                }

            }

        }

        //сумма на разргрузку и подъем
        $unloadAndLiftPrice = max($movers['loader_min']['value'], ($unloadPrice + $liftPrice));

        $totalPrice = $transportationPrice + $unloadAndLiftPrice + (($transportationPrice + $unloadAndLiftPrice) * ($delivery['extra_charge_cost'] / 100));



        $response = [
            'inTTK' => $request['inTTK'],
            'inMkad' => $request['inMkad'],
            'inMO' => $request['inMO'],
            'distance' => $request['distance'],
            'duration' => $duration,
            'delivery' => $delivery,
            'movers' => $movers,
            'transport' => $transports,
            'needTransport' => $needTransport,
            'sumWeight' => $sumWeight,
            'sumVolume' => $sumVolume,
            'manipulator' => $request['manipulator'],
            'toMkadDistance' => $request['toMkadDistance'],
            'floor' => $request['floor'],
            'techFloor' => $request['techFloor'],
            'overCarry' => $request['overCarry'],
            'overCarryValue' => $request['overCarryValue'],
            'cleaning' => $request['cleaning'],
            'unloadPrice' => $unloadPrice,
            'liftPrice' => $liftPrice,
            'unloadAndLiftPrice' => $unloadAndLiftPrice,
            'returnTransport' => $returnTransport,
            'transportationPrice' => $transportationPrice,
            'products' => $products,
            'totalPrice' => round($totalPrice, 2)
        ];

        return response()->json(['data' => $response], 204);
//            return $response;

    }

}
