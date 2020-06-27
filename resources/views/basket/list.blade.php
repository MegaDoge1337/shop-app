@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="laravel_crud">
                        <thead>
                        <tr>
                            <th>Shop</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sellers_id as $seller)
                            <tr>
                                <td><a href="{{ route('basket.show', $seller) }}">{{ $sellers_names[$seller] }}</a></td>
                                <td>
                                    <form action="{{ route('order.make') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                                        <input type="hidden" name="seller_id" value="{{ $seller }}">
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
@endsection
