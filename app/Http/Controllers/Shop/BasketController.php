<?php

namespace App\Http\Controllers\Shop;

use App\Entities\BasketEntity;
use App\Entities\BasketProductEntity;
use App\Http\Controllers\Controller;
use App\Repositories\BasketProductRepositoryInterface;
use App\Repositories\BasketRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\SellerRepositoryInterface;
use App\Services\TotalSumCalculator;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    protected TotalSumCalculator $totalSumCalculator;
    protected BasketProductRepositoryInterface $basketProductRepository;
    protected BasketRepositoryInterface $basketRepository;
    protected ProductRepositoryInterface $productRepository;
    protected CustomerRepositoryInterface $customerRepository;
    protected SellerRepositoryInterface $sellerRepository;

    public function __construct(TotalSumCalculator $totalSumCalculator,
                                BasketProductRepositoryInterface $basketProductRepository,
                                BasketRepositoryInterface $basketRepository,
                                ProductRepositoryInterface $productRepository,
                                CustomerRepositoryInterface $customerRepository,
                                SellerRepositoryInterface $sellerRepository)
    {
        $this->middleware('auth');

        $this->totalSumCalculator = $totalSumCalculator;
        $this->basketProductRepository = $basketProductRepository;
        $this->basketRepository = $basketRepository;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->sellerRepository = $sellerRepository;
    }

    public function index()
    {
        $customer = $this->customerRepository->findById(\Auth::id());

        $baskets = $this->basketRepository->findCustomerBaskets($customer);

        foreach ($baskets as $basket)
        {
            $basketProducts = $this->basketProductRepository->findProductsByBasket($basket);

            $products = $this->productRepository->findByBasketProducts($basketProducts);

            $basket->changeProductsList($products);
        }

        return view('basket.list', [
            'baskets' => collect($baskets),
            'totalSumCalculator' => $this->totalSumCalculator
        ]);
    }

    public function store(Request $request)
    {
        $product = $this->productRepository->findById($request->product_id);

        $customer = $this->customerRepository->findById(\Auth::id());

        $seller = $this->sellerRepository->findById($product->sellerId);

        $basketProduct = BasketProductEntity::create($product->id);

        $basketProduct = $this->basketProductRepository->add($basketProduct);

        if($basketProduct == null)
        {
            return \redirect()->back()->with('error', 'Something went wrong');
        }

        $basket = BasketEntity::create($seller, $customer, [$basketProduct->id]);

        $newBasket = $this->basketRepository->add($basket);

        if($newBasket == null)
        {
            $this->basketRepository->save($basket);
        }

        return \redirect()->back();
    }

    public function destroy($id)
    {
        $basket = $this->basketRepository->findById($id);

        $this->basketProductRepository->delete($basket);

        $this->basketRepository->delete($basket);
    }
}
