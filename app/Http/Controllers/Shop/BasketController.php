<?php

namespace App\Http\Controllers\Shop;

use App\Basket;
use App\Http\Controllers\Controller;
use App\Product;
use App\Seller;
use App\Services\TotalSumCalculator;
use App\User;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    protected TotalSumCalculator $sumCalculator;

    public function __construct(TotalSumCalculator $sumCalculator)
    {
        $this->middleware('auth');

        $this->sumCalculator = $sumCalculator;
    }

    public function index(TotalSumCalculator $sumCalculator)
    {

        $baskets = [];

        \Auth::user()
            ->basket()
            ->each(function ($basket) use (&$baskets) {

                $product = $basket->product()->first();

                $shopTitle = Seller::find($product->seller_id)->user()->first()->name;

                $baskets[$shopTitle][] = $product;

            });

        foreach ($baskets as $shopTitle => $basket)
        {
            $baskets[$shopTitle]['sum'] = $sumCalculator->handler($basket);
        }

        return view('basket.list', [
            'baskets' => $baskets,
            'customer' => \Auth::id(),
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::find($request->product_id);

        $data = [
            'seller_id' => $request->seller_id,
            'customer_id' => \Auth::id(),
            'product_id' => $product->id,
        ];

        Basket::create($data);

        return \redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
