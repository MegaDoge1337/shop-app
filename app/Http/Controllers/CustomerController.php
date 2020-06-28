<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $customer = Customer::firstOrCreate(['user_id' => $user_id])->first()->id;

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
