@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    @if(isset($warning))
                        <div class="alert alert-warning" role="alert">
                            {{ $warning }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">Single Product</div>
                        <div class="card-body" style="width: 46rem;">
                            <h5><b>{{ $product->title }}</b></h5>
                            <ul>
                                <li><b>Price:</b> {{ $product->price }}</li>
                                <li><b>Description: </b>{{ $product->description }}</li>
                                <li><b>Image:</b></li>
                            </ul>
                            <img src="{{ $product->imageUrl }}"><br><br>

                            @if($your_product)
                                <form action="{{ route('shop.single', [$product->sellerId, $product->id])  }}"
                                      method="get">
                                    <input type="hidden" name="warning"
                                           value="You can't add to basket your own product!">
                                    <button class="btn btn-primary" type="submit">Add to
                                        basket
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('basket.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id"
                                           value="{{ $product->id }}">
                                    <input type="hidden" name="seller_id"
                                           value="{{ $product->sellerId }}">
                                    <button class="btn btn-primary" type="submit">
                                        @if($in_basket)
                                            In Basket
                                        @else
                                            Add to Basket
                                        @endif
                                    </button>
                                </form>
                            @endif
                            <br>
                            <a class="btn btn-primary" href="{{ redirect()->back()->getTargetUrl() }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
