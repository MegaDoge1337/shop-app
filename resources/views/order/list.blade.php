@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <div class="list-group">
                        @foreach($orders as $order)
                            <div class="card">
                                <h5 class="card-header">Order No{{ $order->id }}</h5>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach($ordersProducts[$order->id] as $product)
                                            <li class="list-group-item">{{ $product->title }}</li>
                                        @endforeach
                                        <li class="list-group-item list-group-item-info">
                                            Address: {{ $order->customer_address }}</li>
                                        <li class="list-group-item list-group-item-primary">
                                            Amount: {{ $order->amount }}</li>
                                    </ul>
                                </div>
                            </div>
                            <br><br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
