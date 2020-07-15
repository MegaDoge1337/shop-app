<?php

namespace App\Http\Controllers\Shop;

use App\BasketProductModel;
use App\Http\Controllers\Controller;
use App\ProductModel;
use App\Repositories\BasketProductRepositoryInterface;
use App\SellerModel;
use App\Services\TotalSumCalculator;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    protected TotalSumCalculator $sumCalculator;
    protected BasketProductRepositoryInterface $basketProductRepository;

    public function __construct(TotalSumCalculator $sumCalculator,
                                BasketProductRepositoryInterface $basketProductRepository)
    {
        $this->middleware('auth');

        $this->sumCalculator = $sumCalculator;
        $this->basketProductRepository = $basketProductRepository;
    }

    public function index(TotalSumCalculator $sumCalculator)
    {
        $baskets = [];

        \Auth::user()
            ->basket()
            ->each(function ($basket) use (&$baskets) {

                $product = $basket->product()->first();

                $shopTitle = SellerModel::find($product->seller_id)->user()->first()->name;

                $baskets[$shopTitle][] = $product;

            });

        foreach ($baskets as $shopTitle => $basket) {
            $baskets[$shopTitle]['sum'] = $sumCalculator->handler($basket);
        }

        return view('basket.list', [
            'baskets' => $baskets,
            'customer' => \Auth::id(),
        ]);
    }

    public function store(Request $request)
    {
        $product = ProductModel::find($request->product_id);

        $data = [
            'seller_id' => $request->seller_id,
            'customer_id' => \Auth::id(),
            'product_id' => $product->id,
        ];

        BasketProductModel::create($data);

        return \redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
