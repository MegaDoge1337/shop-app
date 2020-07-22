@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Single Product</div>
                        <div class="card-body" style="width: 46rem;">
                            <h5><b>{{ $product->profile->title }}</b></h5>
                            <ul>
                                <li><b>Price:</b> {{ $product->price }}</li>
                                <li><b>Description: </b>{{ $product->profile->description }}</li>
                                <li><b>Image:</b></li>
                            </ul>
                            <img src="{{ $product->profile->imageUrl }}"><br><br>

                                <form action="{{ route('basket.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id"
                                           value="{{ $product->id }}">
                                    <input type="hidden" name="seller_id"
                                           value="{{ $product->sellerId }}">
                                    <button class="btn btn-primary" type="submit">
                                        @if(\App\Entities\Values\BasketProduct::hasProduct($userBasketProducts, $product->id))
                                            In Basket
                                        @else
                                            Add to Basket
                                        @endif
                                    </button>
                                </form>
                            <br>
                            <a class="btn btn-primary" href="{{ redirect()->back()->getTargetUrl() }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
