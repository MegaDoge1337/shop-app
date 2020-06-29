<?php

namespace App\Http\Controllers;

use App\Product;
use App\Seller;
use App\User;
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
        $shops = User::join('sellers', 'sellers.user_id', '=', 'users.id')
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
        $user_id = $request->user()->id;

        $seller = Seller::where('user_id', $user_id)->first();

        if($seller == null)
        {
            $data['products'] = Product::where('seller_id', $id)->orderBy('created_at','desc')->paginate(10);

            return view('shop.products',$data);
        }

        if($seller->id != $id)
        {
            $data['products'] = Product::where('seller_id', $id)->orderBy('created_at','desc')->paginate(10);

            return view('shop.products',$data);
        }

        return redirect('seller');
    }
}
