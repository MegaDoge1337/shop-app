<?php

namespace App\Http\Controllers\Shop;

use App\BasketProductModel;
use App\OrderModel;
use App\ProductModel;
use App\Http\Controllers\Controller;
use App\SellerModel;
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

    public function make(Request $request)
    {
        return view('order.make', [
            'seller_id' => User::where('name', $request->shop_title)->first()->id,
            'address' => User::find(\Auth::id())->address,
            ]);
    }


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

        $order = OrderModel::find(OrderModel::create($data)->id);

        $order->products = $basket;

        $order->save();

        BasketProductModel::where('seller_id', $data['seller_id'])
            ->where('customer_id', $data['customer_id'])
            ->delete();

        return redirect('/customer/orders');
    }

    public function changeStatus(Request $request)
    {
        $order = OrderModel::find($request->order_id);

        $order->status = $request->status;

        $order->save();

        return redirect('/seller/orders');
    }
}
