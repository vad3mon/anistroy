<?php

namespace App\Http\Controllers;

use App\Mail\OrderMailer;
use App\Models\Basket;
use App\Models\Order;
use App\Services\BasketService;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BasketController extends Controller
{
    private CategoryService $categoryService;
    private ProductService $productService;
    private BasketService $basketService;


    public function __construct(ProductService $productService, CategoryService $categoryService, BasketService $basketService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->basketService = $basketService;
    }


    public function index()
    {
        $basket = $this->basketService->getBasket();
        $categories = $this->categoryService->getAllCategories();
        $products = $basket->products;
        $amount = $this->basketService->getAmount($basket);

        return view('basket.index', compact('categories', 'products', 'amount'));
    }

    public function add($id, Request $request)
    {
        $basket = $this->basketService->getBasket();
        $quantity = $request['quantity'] ?? 1;
        if ($this->basketService->getProduct($basket->id, $id)) {
            $categories = $this->categoryService->getAllCategories();
            $products = $basket->products;
            $amount = $this->basketService->getAmount($basket);
            return view('basket.index', compact('categories', 'products', 'amount'));
        }

        $this->basketService->increase($basket->id, $id, $quantity);

        return back();
    }

    public function plus($product_id)
    {
        $basket = $this->basketService->getBasket();
        $this->basketService->increase($basket->id, $product_id);

        return redirect()->route('basket.index');
    }

    public function minus($product_id)
    {
        $basket = $this->basketService->getBasket();
        $this->basketService->decrease($basket->id, $product_id);

        return redirect()->route('basket.index');
    }

    public function remove($product_id)
    {
        $basket = $this->basketService->getBasket();
        $this->basketService->remove($basket->id, $product_id);

        return redirect()->route('basket.index');
    }

    public function saveOrder(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|max:255',
                'address' => 'max:255'
            ]);

        $user_id = !empty($request->user()) ? $request->user()->id : null;
        $session_id = empty($user_id) ? session()->getId() : null;
        $order = $this->basketService->saveOrder($request);

        return redirect()->route('getOrder', ['session_id' => $session_id ?? $user_id, 'order_id' => $order->id]);

    }

}
