<?php

namespace App\Http\Controllers\Shop;

use App\Entities\BasketEntity;
use App\Entities\OrderEntity;
use App\Http\Controllers\Controller;
use App\Policies\OrderPolicy;
use App\Repositories\BasketRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\SellerRepositoryInterface;
use App\Services\TotalSumCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    protected TotalSumCalculator $totalSumCalculator;
    protected SellerRepositoryInterface $sellerRepository;
    protected CustomerRepositoryInterface $customerRepository;
    protected BasketRepositoryInterface $basketRepository;
    protected ProductRepositoryInterface $productRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected OrderPolicy $orderPolicy;

    public function __construct(TotalSumCalculator $sumCalculator,
                                SellerRepositoryInterface $sellerRepository,
                                CustomerRepositoryInterface $customerRepository,
                                BasketRepositoryInterface $basketRepository,
                                ProductRepositoryInterface $productRepository,
                                OrderRepositoryInterface $orderRepository,
                                OrderPolicy $orderPolicy)
    {
        $this->middleware('auth');

        $this->totalSumCalculator = $sumCalculator;
        $this->sellerRepository = $sellerRepository;
        $this->customerRepository = $customerRepository;
        $this->basketRepository = $basketRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->orderPolicy = $orderPolicy;
    }

    public function make(Request $request)
    {
        return view('order.make', [
            'basket_id' => $request->basket_id,
            'address' => $this->customerRepository->findById(\Auth::id())->address,
        ]);
    }


    public function store(Request $request)
    {

        $basket = $this->basketRepository->findBasketById($request->basket_id);

        $basket = $this->basketRepository->syncBaskets(collect([$basket]))->first();

        $order = OrderEntity::create($basket->seller,
            $basket->customer,
            $request->address,
            $basket->products,
            $basket->pricesTotalSum($this->totalSumCalculator),
            1);

        $basket = $this->basketRepository->findBasketById($basket->id);

        $this->orderRepository->add($order);

        $this->basketRepository->deleteBasketProduct($basket);

        $this->basketRepository->deleteBasket($basket);

        return \Redirect::route('customer.orders');
    }

    public function changeStatus(Request $request)
    {
        $order = $this->orderRepository->findById($request->order_id);

        if (!$this->orderPolicy->allowUpdate(\Auth::user(), $order)) return Redirect::route('error.403');

        $order->changeStatus($request->status);

        $this->orderRepository->save($order);

        return \Redirect::route('seller.orders');
    }
}
