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
                                            <h3><b>{{ $order->seller->name }}</b></h3><br>
                                            <b>Address:</b> {{ $order->customerAddress }}<br>
                                            <b>Date:</b> {{ $order->createdAt }}<br>
                                            <b>Total sum:</b> {{ $order->totalSum }}<br>
                                            <ul>
                                                @foreach($order->products as $product)
                                                    <li><b>{{ $product['profile']['title'] }}</b> |
                                                        <b>Price:</b> {{ $product['price'] }}</li>
                                                @endforeach
                                            </ul>
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
