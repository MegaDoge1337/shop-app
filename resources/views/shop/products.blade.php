@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="laravel_crud">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ date('Y-m-d', strtotime($product->created_at)) }}</td>
                                <td>{{ date('Y-m-d', strtotime($product->updated_at)) }}</td>
                                <td>
                                    <form action="{{ route('basket.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="seller_id" value="{{ $product->seller_id }}">
                                        <button class="btn btn-primary" type="submit">Add to
                                            cart</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
