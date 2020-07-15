<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\OrderModel;
use App\ProductModel;
use App\Repositories\ProductEloquentRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SellerController extends Controller
{

    protected ProductEloquentRepository $productRepository;

    public function __construct(ProductEloquentRepository $productRepository)
    {
        $this->middleware('auth');

        $this->productRepository = $productRepository;
    }

    public function index()
    {

        $seller_id = \Auth::user()->seller->id;

        return view('seller.list', [
            'products' => $this->productRepository->findAllBySellerId($seller_id)
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

        $product = $this->productRepository->add($request->all());

        $this->productRepository->save($product);

//        ProductModel::create([
//            'seller_id' => \Auth::user()->seller->id,
//            'title' => $request->title,
//            'price' => $request->price,
//            'description' => $request->description,
//            'image_url' => $request->image_url,
//        ]);

        return Redirect::to('seller')
            ->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = $this->productRepository->findById($id);

        return view('seller.edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image_url' => 'required',
        ]);

        $product = $this->productRepository->findById($id);

        $product->profile->changeProfile([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $request->image_url
        ]);

        $this->productRepository->save($product);

        return Redirect::to('seller')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = $this->productRepository->findById($id);

        if($product->canBeDeleted('some policy'))
        {
            $this->productRepository->delete($product);

            return Redirect::to('seller')
                ->with('success', 'Product deleted successfully!');
        }
        return Redirect::to('seller');
    }

    public function ordersForSeller()
    {
        $orders = [];

        OrderModel::where('seller_id', \Auth::user()->seller()->first()->id)
            ->get()
            ->each(function ($order) use (&$orders) {

                $customer = User::find($order->customer_id)->first();

                $orders[$order->id]["customer"] = $customer->name;

                $orders[$order->id]["products"] = collect($order->products);

                $orders[$order->id]["address"] = $order->customer_address;

                $orders[$order->id]["date"] = $order->created_at;

                $orders[$order->id]["sum"] = $order->total_sum;

                $orders[$order->id]["status"] = $order->status;
            });

        return view('order.seller_list', [
            'orders' => $orders,
        ]);
    }
}
