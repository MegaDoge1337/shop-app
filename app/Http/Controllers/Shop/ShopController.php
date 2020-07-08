<?php

namespace App\Http\Controllers\Shop;

use App\BasketModel;
use App\ProductModel;
use App\SellerModel;
use App\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
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
    public function index()
    {
        $shops = UserModel::join('sellers', 'sellers.user_id', '=', 'users.id')
            ->get()->all();

        $data['shops'] = $shops;

        return view('shop.list', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $seller = SellerModel::where('user_id', \Auth::id())->first();

        $products = ProductModel::where('seller_id', $id)->orderBy('created_at','desc')->paginate(10);

        $inBasket = [];

        foreach ($products as $product)
        {
            if(BasketModel::where('customer_id', \Auth::id())->where('product_id', $product->id)->first())
            {
                $inBasket[$product->id] = true;
                continue;
            }
            $inBasket[$product->id] = false;
        }

        if($seller == null)
        {
            return view('shop.products',[
                'seller' => SellerModel::find($id)->user()->first(),
                'products' => $products,
            ]);
        }

        if($seller->id != $id)
        {

            return view('shop.products',[
                'seller' => SellerModel::find($id)->user()->first(),
                'products' => $products,
                'inBasket' => $inBasket,
            ]);
        }

        return view('shop.myproducts',[
            'products' => $products,
            'warning' => $request->warning,
        ]);
    }

    public function singleProduct($seller_id, $product_id, Request $request)
    {
        $seller = SellerModel::where('user_id', \Auth::id())->first();

        $inBasket = BasketModel::where('customer_id', \Auth::id())
            ->where('product_id', $product_id)
            ->first();

        if($inBasket != null) $inBasket = true;

        if($seller == null || $seller->id != $seller_id)
        {
            return view('shop.single_product',[
                'product' => ProductModel::find($product_id),
                'your_product' => 0,
                'warning' => '',
                'in_basket' => $inBasket,
            ]);
        }

        return view('shop.single_product',[
            'product' => ProductModel::find($product_id),
            'your_product' => 1,
            'warning' => $request->warning ?? '',
            'in_basket' => $inBasket,
        ]);
    }
}
