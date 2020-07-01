@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="width: 46rem;">
                        <div class="card-header">Baskets List</div>
                        <div class="card-body">
                            <table class="table table-bordered" id="laravel_crud">
                                <thead>
                                <tr>
                                    <th>Baskets</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sellers_info as $id => $seller)
                                    <tr>
                                        <td>
                                            <h3>{{ $seller }}</h3>
                                            <ul>
                                            @foreach($products[$id] as $product)
                                                <li>{{ $product->title }} (Price: {{ $product->price }})</li>
                                            @endforeach
                                                <li><b>Total: {{ $total_prices[$id] }}</b></li>
                                            </ul>
                                        </td>
                                        <td align="center">
                                            <form action="{{ route('order.make') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                                                <input type="hidden" name="seller_id" value="{{ $id}}">
                                                <button class="btn btn-primary" type="submit">Make order</button>
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
