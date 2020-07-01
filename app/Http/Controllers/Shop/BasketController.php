<?php

namespace App\Http\Controllers\Shop;

use App\Basket;
use App\Http\Controllers\Controller;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $baskets = User::find(\Auth::id())->basket()->get();

        $sellersInfo = [];

        $basketProducts = [];

        $products = [];

        $totalPrices = [];

        foreach ($baskets as $basket) {

            if (array_key_exists($basket->seller_id, $sellersInfo)) continue;

            $sellersInfo[$basket->seller_id] =
                Seller::find($basket->seller_id)
                    ->user()
                    ->first()
                    ->name;

            $basketProducts[$basket->seller_id] = Basket::where('seller_id', $basket->seller_id)
                ->where('customer_id', \Auth::id())
                ->get();
        }

        foreach ($baskets as $basket)
        {
            if (array_key_exists($basket->seller_id, $products)) continue;

            foreach ($basketProducts[$basket->seller_id] as $product)
            {
                $products[$basket->seller_id][] = Product::where('id', $product->product_id)->first();
            }

            $totalPrices[$basket->seller_id] = 0;

           foreach($products[$basket->seller_id] as $product)
           {
               $totalPrices[$basket->seller_id] += $product->price;
           }
        }

        return view('basket.list', [
            'products' => $products,
            'total_prices' => $totalPrices,
            'sellers_info' => $sellersInfo,
            'customer_id' => \Auth::id()
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
        $product = Product::find($request->product_id);

        $data = [
            'seller_id' => $request->seller_id,
            'customer_id' => \Auth::id(),
            'product_id' => $product->id,
        ];

        Basket::create($data);

        return \redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
