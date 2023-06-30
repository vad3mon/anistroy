<?php

namespace App\Http\Controllers;

use App\Mail\OrderMailer;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Settings;
use App\Models\Transport;
use App\Services\BasketService;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use MoveMoveIo\DaData\Facades\DaDataAddress;

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

    public function newBasket()
    {
        $basket = $this->basketService->getBasket();
        $categories = $this->categoryService->getAllCategories();
        $products = $basket->products;
        $amount = $this->basketService->getAmount($basket);
        $settings = Settings::get()->pluck('settings')->first();

        return view('basket.new', compact('categories', 'products', 'amount', 'settings'));
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

    public function stringAddress(Request $request)
    {
        $dadata = DaDataAddress::geolocate($request['coords'][0], $request['coords'][1], 1);

        return response()->json(
            [
                $dadata["suggestions"][0]["value"]
            ], 200);
    }

    public function coordsAddress(Request $request)
    {
        $dadata = DaDataAddress::prompt($request['stringAddress'], 1);
//        $dadata = DaDataAddress::prompt($request['stringAddress']);

        return response()->json(
            [
                $dadata["suggestions"][0]["data"]
            ], 200);
    }

    public function saveNewOrder(Request $request)
    {
//        $this->validate($request,
//            [
//                'name' => 'required|max:255',
//                'email' => 'required|email|max:255',
//                'phone' => 'required|max:255',
//                'address' => 'max:255'
//            ]);

        $user_id = !empty($request->user()) ? $request->user()->id : null;
        $session_id = empty($user_id) ? session()->getId() : null;

        $order = $this->basketService->saveNewOrder($request);

        return $order;

//        return redirect()->route('getOrder', ['session_id' => $session_id ?? $user_id, 'order_id' => $order->id]);
    }

    public function getDeliveryPrice(Request $request)
    {
        $response = $this->basketService->getDeliveryPrice($request);



        return response()->json(
            $response, 200);
    }
}
