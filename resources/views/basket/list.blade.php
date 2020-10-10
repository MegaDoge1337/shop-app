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
                                @foreach($baskets as $basket)
                                    <tr>
                                        <td>
                                            <h3>{{ $basket->seller->name }}</h3>
                                            <ul>
                                                @foreach($basket->products as $product)
                                                    @if($product->deleted)
                                                        <li><div class="alert alert-danger" role="alert">
                                                            {{ $product->title }}
                                                        </div></li>
                                                    @else
                                                        <li>{{ $product->title }} (Price: {{ $product->price }})</li>
                                                    @endif
                                                @endforeach
                                                <li><b>Total sum:</b> {{ $basket->pricesTotalSum($totalSumCalculator) }}</li>
                                            </ul>
                                        </td>
                                        <td align="center">
                                            <form action="{{ route('order.make') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="basket_id" value="{{ $basket->id }}">
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
