<?php

namespace App\Http\Controllers\Shop;

use App\Basket;
use App\Order;
use App\Product;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function make(Request $request)
    {
        return view('order.make', [
            'seller_id' => $request->seller_id,
            'address' => User::find(\Auth::id())->address,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'seller_id' => $request->seller_id,
            'customer_id' => \Auth::id(),
            'customer_address' => $request->address,
            'products_id' => '',
            'amount' => '',
            'status' => '1',
        ];

        $baskets = Basket::where('seller_id', $data['seller_id'])
            ->where('customer_id', $data['customer_id'])
            ->get();

        $amount = 0;
        $productsList = [];

        foreach ($baskets as $basket) {

            $amount += Product::where('id', $basket->product_id)
                ->first()
                ->price;

            $productsList[] = $basket->product_id;
        }

        $data['products_id'] = $productsList;
        $data['amount'] = $amount;

        $order = Order::find(Order::create($data)->id);

        $order->products_id = $productsList;

        $order->save();

        Basket::where('seller_id', $data['seller_id'])
            ->where('customer_id', $data['customer_id'])
            ->delete();

        return redirect('/customer/orders');
    }

    public function ordersForSeller()
    {
        $orders = Order::where('seller_id', User::find(\Auth::id())->seller()->first()->id)->get();

        $ordersProducts = [];

        $userInfo = [];

        foreach ($orders as $order)
        {
            $customer = Order::find($order->id)->user()->first();

            $userInfo[$customer->id] = $customer;

            $products = $order->products_id;

            $ordersProducts[$order->id] = [];

            foreach ($products as $product)
            {
                $productInfo = Product::find($product);

                if($productInfo)
                {
                    $ordersProducts[$order->id][] = $productInfo;
                }
            }
        }

        return view('order.seller_list', [
            'orders' => $orders,
            'orders_products' => $ordersProducts,
            'user_info' => $userInfo,
        ]);
    }

    public function ordersForCustomer()
    {
        $orders = User::find(\Auth::id())->order()->get();

        $ordersProducts = [];

        $userInfo = [];

        foreach ($orders as $order)
        {
            $seller = Order::find($order->id)->seller()->first();

            $userInfo[$seller->id] = User::find($seller->user_id);

            $products = $order->products_id;

            $ordersProducts[$order->id] = [];

            foreach ($products as $product)
            {
                $productInfo = Product::find($product);

                if($productInfo)
                {
                    $ordersProducts[$order->id][] = $productInfo;
                }
            }
        }

        return view('order.customer_list', [
            'orders' => $orders,
            'orders_products' => $ordersProducts,
            'user_info' => $userInfo,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $order = Order::find($request->order_id);

        $order->status = $request->status;

        $order->save();

        return redirect('/seller/orders');
    }
}
