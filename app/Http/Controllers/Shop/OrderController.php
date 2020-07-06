<?php

namespace App\Http\Controllers\Shop;

use App\Basket;
use App\Order;
use App\Product;
use App\Http\Controllers\Controller;
use App\Seller;
use App\Services\TotalSumCalculator;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected TotalSumCalculator $sumCalculator;

    public function __construct(TotalSumCalculator $sumCalculator)
    {
        $this->middleware('auth');

        $this->sumCalculator = $sumCalculator;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function make(Request $request)
    {
        return view('order.make', [
            'seller_id' => User::where('name', $request->shop_title)->first()->id,
            'address' => User::find(\Auth::id())->address,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TotalSumCalculator $sumCalculator)
    {

        $data = [
            'seller_id' => $request->seller_id,
            'customer_id' => \Auth::id(),
            'customer_address' => $request->address,
            'products' => '',
            'total_sum' => '',
            'status' => '1',
        ];

        $basket = [];

        \Auth::user()
            ->basket()
            ->where('seller_id', $request->seller_id)
            ->each(function ($baskets) use (&$basket) {

                $product = $baskets->product()->first();

                $basket[] = $product;

            });

        $data['total_sum'] = $sumCalculator->handler($basket);

        $order = Order::find(Order::create($data)->id);

        $order->products = $basket;

        $order->save();

        Basket::where('seller_id', $data['seller_id'])
            ->where('customer_id', $data['customer_id'])
            ->delete();

        return redirect('/customer/orders');
    }

    public function changeStatus(Request $request)
    {
        $order = Order::find($request->order_id);

        $order->status = $request->status;

        $order->save();

        return redirect('/seller/orders');
    }
}
