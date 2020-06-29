<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Customer;
use App\Order;
use App\Product;
use App\Seller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function make(Request $request)
    {
        $data['seller_id'] = $request->seller_id;
        $data['customer_id'] = $request->customer_id;

        return view('order.make', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller_id = $request->seller_id;
        $customer_id = $request->customer_id;
        $address = $request->address;

        $basketContent = Basket::where('seller_id', $seller_id)
            ->where('customer_id', $customer_id)->get();

        $amount = 0;
        $products_json = [];

        foreach ($basketContent as $item) {
            $amount += Product::where('id', $item->product_id)->first()->price;
            $products_json[] = $item->product_id;
        }

        $products_json = json_encode($products_json);

        $data = [
            'seller_id' => $seller_id,
            'customer_id' => $customer_id,
            'customer_name' => 'DELETE',
            'customer_address' => $address,
            'products_id' => $products_json,
            'amount' => $amount
        ];

        Order::create($data);

        Basket::where('seller_id', $seller_id)
            ->where('customer_id', $customer_id)
            ->delete();

        return redirect('/customer/orders');
    }

    public function ordersForSeller(Request $request)
    {
        $user_id = $request->user()->id;

        $seller = Seller::firstOrCreate(['user_id' => $user_id])->first()->id;

        $orders = Order::where('seller_id', $seller)
            ->get();

        $ordersProducts = [];

        foreach ($orders as $order)
        {
            $products = json_decode($order->products_id);

            $ordersProducts[$order->id] = [];

            foreach ($products as $product)
            {
                $productInfo = Product::where('id', $product)->first();

                if($productInfo)
                {
                    $ordersProducts[$order->id][] = $productInfo;
                }
            }
        }

        $data['orders'] = $orders;
        $data['ordersProducts'] = $ordersProducts;

        return view('order.list', $data);
    }

    public function ordersForCustomer(Request $request)
    {
        $user_id = $request->user()->id;

        Customer::firstOrCreate(['user_id' => $user_id])->first()->id;

        $customer = Customer::where('user_id', $user_id)->first()->id;

        $orders = Order::where('customer_id', $customer)
            ->get();

        $ordersProducts = [];

        foreach ($orders as $order)
        {
            $products = json_decode($order->products_id);

            $ordersProducts[$order->id] = [];

            foreach ($products as $product)
            {
                $productInfo = Product::where('id', $product)->first();

                if($productInfo)
                {
                    $ordersProducts[$order->id][] = $productInfo;
                }
            }
        }

        $data['orders'] = $orders;
        $data['ordersProducts'] = $ordersProducts;

        return view('order.list', $data);
    }
}
