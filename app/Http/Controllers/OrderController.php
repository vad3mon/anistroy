<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function show(Request $request, $session_id, $order_id)
    {
        $order = $this->orderService->getOrder($order_id);

        return view('orders.order', compact('order'));
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->getOrders($request);

        return view('orders.index', compact('orders'));
    }
}
