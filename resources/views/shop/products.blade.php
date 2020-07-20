@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">{{ $seller->name }} Products</div>
                        <div class="card-body">
                            <table class="table table-bordered" id="laravel_crud">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ route('shop.single', [$product->sellerId, $product->id]) }}">{{ $product->profile->title }}</a>
                                        </td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->profile->description }}</td>
                                        <td><img src="{{ $product->profile->imageUrl }}"></td>
                                        <td>
                                            <form action="{{ route('basket.store')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="seller_id"
                                                       value="{{ $product->sellerId }}">
                                                <button class="btn btn-primary" type="submit">
                                                        @if(\App\Entities\BasketProductEntity::actualize($userBasketProducts, $product->id))
                                                            In Basket
                                                        @else
                                                            Add to Basket
                                                        @endif
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
