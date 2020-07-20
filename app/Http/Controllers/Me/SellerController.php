<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\SellerRepositoryInterface;

class SellerController extends Controller
{
    protected SellerRepositoryInterface $sellerRepository;
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(SellerRepositoryInterface $sellerRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->middleware('auth');

        $this->sellerRepository = $sellerRepository;
        $this->orderRepository = $orderRepository;
    }

    public function ordersForSeller()
    {
        $orders = $this->orderRepository->findBySellerId(\Auth::id());

        return view('order.seller_list', [
            'orders' => $orders,
        ]);
    }
}
