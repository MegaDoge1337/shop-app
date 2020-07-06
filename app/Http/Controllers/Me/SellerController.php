<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SellerController extends Controller
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
        $seller = User::find(\Auth::id())
            ->seller()
            ->first();

        return view('seller.list', [
            'products' => Seller::find($seller->id)
                ->product()
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ]);
    }

    public function create()
    {
        return view('seller.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image_url' => 'required',
        ]);

        $data = [
            'seller_id' => Seller::firstWhere('user_id', \Auth::id())->id,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ];

        Product::create($data);

        return Redirect::to('seller')
            ->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['product'] = Product::firstWhere('id', $id);

        $seller_id = Seller::firstWhere('user_id', \Auth::id())->id;

        if ($data['product']->seller_id != $seller_id) {
            return \redirect('seller');
        }

        return view('seller.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image_url' => 'required',
        ]);

        $update = [
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ];

        Product::where('id', $id)->update($update);

        return Redirect::to('seller')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        Seller::firstWhere('user_id', \Auth::id())
            ->product()
            ->where('id', $id)
            ->delete();

        return Redirect::to('seller')
            ->with('success', 'Product deleted successfully!');
    }

    public function ordersForSeller()
    {
        $orders = [];

        Order::where('seller_id', \Auth::user()->seller()->first()->id)
            ->get()
            ->each(function ($order) use (&$orders){

                $customer = User::find($order->customer_id)->first();

                $orders[$order->id]["customer"] = $customer->name;

                $orders[$order->id]["products"] = collect($order->products);

                $orders[$order->id]["address"] = $order->customer_address;

                $orders[$order->id]["date"] = $order->created_at;

                $orders[$order->id]["sum"] = $order->total_sum;

                $orders[$order->id]["status"] = $order->status;
            });

        //dd($orders);

        return view('order.seller_list', [
            'orders' => $orders,
        ]);
    }
}
