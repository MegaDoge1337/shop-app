<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\BasketProductRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\SellerModel;
use App\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    protected ProductRepositoryInterface $productRepository;
    protected BasketProductRepositoryInterface $basketProductRepository;
    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository,
                                ProductRepositoryInterface $productRepository,
                                BasketProductRepositoryInterface $basketProductRepository)
    {
        $this->middleware('auth');

        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->basketProductRepository = $basketProductRepository;
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
        $seller = SellerModel::where('user_id', \Auth::id())->first();

        $customer = $this->customerRepository->findById(\Auth::id());

        $products = $this->productRepository->findAllBySellerId($id);

        $userBasketProducts = $this->basketProductRepository->findAllByCustomerId($customer->id);

        return view('shop.products', [
            'seller' => $seller,
            'customer' => $customer,
            'userBasketProducts' => $userBasketProducts,
            'products' => $products
        ]);
    }

    public function singleProduct($seller_id, $product_id, Request $request)
    {
        $seller = SellerModel::where('user_id', \Auth::id())->first();

        $product = $this->productRepository->findById($product_id);

        $inBasket = $this->basketProductRepository->findByProductId($product_id, \Auth::id());

        if ($seller->id == $seller_id) {
            return view('shop.single_product', [
                'product' => $product,
                'your_product' => true,
                'warning' => $request->warning
            ]);
        }

        return view('shop.single_product', [
            'product' => $product,
            'your_product' => false,
            'in_basket' => $inBasket ?? false
        ]);
    }
}
