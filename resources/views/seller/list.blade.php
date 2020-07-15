@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">My Products</div>
                        <div class="card-body">
                            <a href="{{ route('seller.create') }}" class="btn btn-success">Add Product</a><br><br>
                            <table class="table table-bordered" id="laravel_crud">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <td colspan="2">
                                        <center><b>Action</b></center>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->profile->title }}</td>
                                        <td>{{ $product->profile->price }}</td>
                                        <td>{{ $product->profile->description }}</td>
                                        <td><img src="{{ $product->profile->imageUrl }}"></td>
                                        <td>{{ date('Y-m-d', strtotime($product->createdAt)) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($product->updatedAt)) }}</td>
                                        <td>
                                            <a href="{{ route('seller.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('seller.destroy', $product->id) }}" method="post">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
{{--                {!! $products->links() !!}--}}
            </div>
        </div>
    </div>
    </div>
@endsection
