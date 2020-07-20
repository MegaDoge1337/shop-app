<?php

namespace App\Http\Controllers\Me;

use App\Entities\ProductEntity;
use App\Entities\Profiles\ProductProfile;
use App\Http\Controllers\Controller;
use App\Policies\ProductPolicy;
use App\Repositories\ProductEloquentRepository;
use App\Repositories\SellerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{

    protected ProductEloquentRepository $productRepository;
    protected SellerRepositoryInterface $sellerRepository;
    protected ProductPolicy $productPolicy;

    public function __construct(ProductEloquentRepository $productRepository,
                                SellerRepositoryInterface $sellerRepository,
                                ProductPolicy $productPolicy)
    {
        $this->middleware('auth');

        $this->productRepository = $productRepository;
        $this->sellerRepository = $sellerRepository;
        $this->productPolicy = $productPolicy;
    }

    public function index()
    {
        $seller = $this->sellerRepository->findById(\Auth::id());

        return view('seller.list', [
            'products' => $this->productRepository->findAllBySellerId($seller->id)
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

        $seller = $this->sellerRepository->findById(\Auth::id());

        $profile = ProductProfile::create($request->title, $request->description, $request->image_url);
        $product = ProductEntity::create($seller->id, $request->price, $profile);

        $product = $this->productRepository->add($product);

        if ($product) {
            return Redirect::to('seller')
                ->with('success', 'Product created successfully!');
        }

        return Redirect::to('seller')
            ->with('error', 'Product already exist!');
    }

    public function edit($id)
    {
        $product = $this->productRepository->findById($id);

        if (!$this->productPolicy->allowUpdate(\Auth::user(), $product)) return Redirect::route('error.403');

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

        if (!$this->productPolicy->allowUpdate(\Auth::user(), $product)) return Redirect::route('error.403');

        $product->profile->changeProfile($request->title, $request->description, $request->image_url);

        $product->changePrice($request->price);

        $this->productRepository->save($product);

        return Redirect::to('seller')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = $this->productRepository->findById($id);

        if (!$this->productPolicy->allowUpdate(\Auth::user(), $product)) return Redirect::route('error.403');

        if ($product->canBeDeleted('some policy')) {
            $this->productRepository->delete($product);

            return Redirect::to('seller')
                ->with('success', 'Product deleted successfully!');
        }
        return Redirect::to('seller');
    }
}
