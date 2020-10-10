<?php

namespace App\Http\Controllers\Shop;

use App\BasketModel;
use App\Entities\BasketEntity;
use App\Entities\Values\BasketProduct;
use App\Http\Controllers\Controller;
use App\Repositories\BasketRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\SellerRepositoryInterface;
use App\Services\TotalSumCalculator;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    protected TotalSumCalculator $totalSumCalculator;
    protected BasketRepositoryInterface $basketRepository;
    protected ProductRepositoryInterface $productRepository;
    protected CustomerRepositoryInterface $customerRepository;
    protected SellerRepositoryInterface $sellerRepository;

    public function __construct(TotalSumCalculator $totalSumCalculator,
                                BasketRepositoryInterface $basketRepository,
                                ProductRepositoryInterface $productRepository,
                                CustomerRepositoryInterface $customerRepository,
                                SellerRepositoryInterface $sellerRepository)
    {
        $this->middleware('auth');

        $this->totalSumCalculator = $totalSumCalculator;
        $this->basketRepository = $basketRepository;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->sellerRepository = $sellerRepository;
    }

    public function index()
    {
        //dd(BasketModel::find(1)->products);

        $customer = $this->customerRepository->findById(\Auth::id());

        $baskets = $this->basketRepository->findCustomerBaskets($customer);

        $syncBaskets = $this->basketRepository->syncBaskets($baskets);

        return view('basket.list', [
            'baskets' => $syncBaskets,
            'totalSumCalculator' => $this->totalSumCalculator
        ]);
    }

    public function store(Request $request)
    {
        $product = $this->productRepository->findById($request->product_id);

        $customer = $this->customerRepository->findById(\Auth::id());

        $seller = $this->sellerRepository->findById($product->sellerId);

        $basketProduct = BasketProduct::create($product->id, $product->price, $product->profile->title);

        $basketProduct = $this->basketRepository->addBasketProduct($basketProduct);

        if($basketProduct == null)
        {
            return \redirect()->back()->with('error', 'Something went wrong');
        }

        $basket = BasketEntity::create($seller, $customer, collect([$basketProduct]));

        $newBasket = $this->basketRepository->addBasket($basket);

        if($newBasket == null)
        {
            $this->basketRepository->saveBasket($basket);
        }

        return \redirect()->back();
    }

    public function destroy($id)
    {
        $basket = $this->basketRepository->findBasketById($id);

        $this->basketRepository->deleteBasketProduct($basket);

        $this->basketRepository->deleteBasket($basket);
    }
}
