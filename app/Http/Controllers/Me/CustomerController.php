<?php

namespace App\Http\Controllers\Me;

use App\OrderModel;
use App\ProductModel;
use App\SellerModel;
use App\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('me.contacts.index', [
            'user' => UserModel::find(\Auth::id())
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/customer/edit/contacts/')
                ->withErrors($validator)
                ->withInput();
        }

        $update = [
            'address' => $request->address
        ];

        UserModel::where('id', $id)->update($update);

        return redirect('/customer/edit/contacts/')
            ->with('success', 'Information has been changed!');
    }

    public function ordersForCustomer()
    {
        $orders = [];

        UserModel::find(\Auth::id())
            ->order()
            ->get()
            ->each(function ($order) use (&$orders){

                $seller = SellerModel::find($order->seller_id)->user()->first();

                $orders[$order->id]["seller"] = $seller->name;

                $orders[$order->id]["products"] = collect($order->products);

                $orders[$order->id]["address"] = $order->customer_address;

                $orders[$order->id]["date"] = $order->created_at;

                $orders[$order->id]["sum"] = $order->total_sum;

                $orders[$order->id]["status"] = $order->status;
            });

        //dd($orders);

        return view('order.customer_list', [
            'orders' => $orders,
        ]);
    }

}
