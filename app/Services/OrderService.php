<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
class OrderService
{
    public function getOrder($order_id)
    {
        $order = Order::find($order_id);

        return $order;
    }

    public function getOrders(Request $request)
    {
        if (!empty($request->user()))
        {
            $orders = Order::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        }

        else {
            $orders = Order::where('session_id', session()->getId())->get();
        }

        return self::paginate($orders, 20);
    }

    public static function paginate(Collection $results, $pageSize)
    {
        $page = Paginator::resolveCurrentPage('page');

        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
