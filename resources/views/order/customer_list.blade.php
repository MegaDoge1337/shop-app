@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="width: 46rem;">
                        <div class="card-header">Orders List</div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach($orders as $order)
                                    <div class="card border-info mb-3">
                                        <h5 class="card-header">Order No{{ $order->id }}</h5>
                                        <div class="card-body">
                                            <h6><b>{{ $user_info[$order->seller_id]->name }} Shop</b></h6>
                                            <a>Products:</a>
                                            <ul>
                                                @foreach($orders_products[$order->id] as $product)
                                                    <li><b>{{ $product->title }}</b> |
                                                        <b>Price:</b> {{ $product->price }} |
                                                        <b>Date:</b> {{ $product->created_at }}</li>
                                                @endforeach
                                            </ul>
                                            <b>Address:</b> {{ $order->customer_address }}<br>
                                            <b>Amount:</b> {{ $order->amount }}
                                            @if($order->status == 1)
                                                <div class="alert alert-primary" role="alert">
                                                    <b>Status: In processing</b>
                                                </div>
                                            @elseif($order->status == 2)
                                                <div class="alert alert-warning" role="alert">
                                                    <b>Status: In transit</b>
                                                </div>
                                            @elseif($order->status == 3)
                                                <div class="alert alert-success" role="alert">
                                                    <b>Status: Delivered</b>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
