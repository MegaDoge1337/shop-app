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
                                <tbody>
                                @foreach($baskets as $shopTitle => $basket)
                                    <tr>
                                        <td>
                                            <h3>{{ $shopTitle }}</h3>
                                            <ul>
                                                @foreach($basket as $key => $product)
                                                    @if($key === "sum")
                                                        <li><b>Total sum: {{ $product }}</b></li>
                                                    @else
                                                        <li>{{ $product->title }} (Price: {{ $product->price }})</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td align="center">
                                            <form action="{{ route('order.make') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="customer_id" value="{{ $customer }}">
                                                <input type="hidden" name="shop_title" value="{{ $shopTitle }}">
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
