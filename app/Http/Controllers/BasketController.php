<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Customer;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $user_id = $request->user()->id;

        Customer::firstOrCreate(['user_id' => $user_id]);

        $customer = Customer::where('user_id', $user_id)->first();

        $basketsContent = Basket::where('customer_id', $customer->id)->get();

        $sellers_id = [];
        $sellers_names = [];

        foreach ($basketsContent as $content)
        {
            if(!in_array($content->seller_id, $sellers_id))
            {
                $sellers_id[] = $content->seller_id;

                $user_id = Seller::where('id', $content->seller_id)->get()->first()->user_id;

                $name = User::where('id', $user_id)->get()->first()->name;

                $sellers_names[$content->seller_id] = $name;
            }
        }

        $data['sellers_id'] = $sellers_id;
        $data['sellers_names'] = $sellers_names;

        $data['customer_id'] = $customer->id;

        return view('basket.list', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user_id = $request->user()->id;

        Customer::firstOrCreate(['user_id' => $user_id]);

        $customer = Customer::where('user_id', $user_id)->first();

        $product = Product::where('id', $request->product_id)->first();

        $data = [
            'seller_id' => $request->seller_id,
            'customer_id' => $customer->id,
            'product_id' => $product->id,
        ];

        Basket::create($data);

        return Redirect::to('basket')
            ->with('success','Greate! Product created successfully.');
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

        Customer::firstOrCreate(['user_id' => $user_id]);

        $customer = Customer::where('user_id', $user_id)->first();

        $basketsContent = Basket::where('customer_id', $customer->id)
            ->join('products', 'baskets.product_id', '=', 'products.id')
            ->get()->where('seller_id', $id)->all();

        $data['basket'] = $basketsContent;

        //dd($basketsContent);

        return view('basket.items', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
