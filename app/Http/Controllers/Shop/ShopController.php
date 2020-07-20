<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\BasketProductRepositoryInterface;
use App\Repositories\BasketRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\SellerRepositoryInterface;
use App\User;

class ShopController extends Controller
{

    protected ProductRepositoryInterface $productRepository;
    protected BasketProductRepositoryInterface $basketProductRepository;
    protected CustomerRepositoryInterface $customerRepository;
    protected SellerRepositoryInterface $sellerRepository;
    protected BasketRepositoryInterface $basketRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository,
                                SellerRepositoryInterface $sellerRepository,
                                ProductRepositoryInterface $productRepository,
                                BasketProductRepositoryInterface $basketProductRepository,
                                BasketRepositoryInterface $basketRepository)
    {
        $this->middleware('auth');

        $this->customerRepository = $customerRepository;
        $this->sellerRepository = $sellerRepository;
        $this->productRepository = $productRepository;
        $this->basketProductRepository = $basketProductRepository;
        $this->basketRepository = $basketRepository;
    }

    public function index()
    {
        return view('shop.list', [
            'sellers' => User::join('sellers', 'sellers.user_id', '=', 'users.id')
                ->select('sellers.id', 'name')
                ->get()
                ->all()
        ]);
    }

    public function show($id)
    {
        $seller = $this->sellerRepository->findById($id);

        $customer = $this->customerRepository->findById(\Auth::id());

        $products = $this->productRepository->findAllBySellerId($id);

        $userBasket = $this->basketRepository->findCustomerBaskets($customer);

        $userBasketProducts = $this->basketProductRepository->findProductsByBaskets($userBasket);

        return view('shop.products', [
            'seller' => $seller,
            'customer' => $customer,
            'userBasketProducts' => $userBasketProducts,
            'products' => $products
        ]);
    }

    public function singleProduct($seller_id, $product_id)
    {
        $seller = $this->sellerRepository->findById($seller_id);

        $customer = $this->customerRepository->findById(\Auth::id());

        $product = $this->productRepository->findById($product_id);

        $userBasket = $this->basketRepository->findCustomerBaskets($customer);

        $userBasketProduct = $this->basketProductRepository->findProductInBaskets($userBasket, $product_id);

        return view('shop.single_product', [
            'seller' => $seller,
            'product' => $product,
            'userBasketProducts' => [$userBasketProduct]
        ]);
    }
}
