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
                                @foreach($orders as $order_id => $order)
                                    <div class="card border-info mb-3">
                                        <h5 class="card-header">Order No{{ $order_id }}</h5>
                                        <div class="card-body">
                                            @foreach($order as $field => $value)
                                                @if($field == "customer")
                                                    <h3><b>{{ $value }}</b></h3><br>
                                                @elseif($field == "address")
                                                    <b>Address:</b> {{ $value }}<br>
                                                @elseif($field == "date")
                                                    <b>Date:</b> {{ $value }}<br>
                                                @elseif($field == "sum")
                                                    <b>Total sum:</b> {{ $value }}<br>
                                                @elseif($field == "products")
                                                    <ul>
                                                    @foreach($value as $products)
                                                            <li><b>{{ $products["title"] }}</b> | <b>Price:</b> {{ $products["price"] }}</li>
                                                    @endforeach
                                                    </ul>
                                                @endif
                                            @endforeach
                                            @if($order["status"] == 1)
                                                <div class="alert alert-primary" role="alert">
                                                    <b>Status: In processing</b>
                                                </div>
                                            @elseif($order["status"] == 2)
                                                <div class="alert alert-warning" role="alert">
                                                    <b>Status: In transit</b>
                                                </div>
                                            @elseif($order["status"] == 3)
                                                <div class="alert alert-success" role="alert">
                                                    <b>Status: Delivered</b>
                                                </div>
                                            @endif
                                            <form action="{{ route('order.update') }}" method="post">
                                                @csrf
                                                <div class="card border-primary mb-3" style="max-width: 40rem;">
                                                    <div class="card-header">Order status</div>
                                                    <div class="card-body text-primary">
                                                        <label><input type="radio" checked name="status" value="1">
                                                            In processing</label>
                                                        <br><label><input type="radio" name="status" value="2">
                                                            In transit</label>
                                                        <br><label><input type="radio" name="status" value="3">
                                                            Delivered</label>
                                                        <input type="hidden" name="order_id" value="{{ $order_id }}">
                                                        <br><button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
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
