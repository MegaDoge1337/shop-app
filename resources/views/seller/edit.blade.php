@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form action="{{ route('seller.update', $product->id) }}" method="POST" name="update_product">
                {{ csrf_field() }}
                @method('PATCH')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Title</strong>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                   value="{{ $product->title }}">
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Product Code</strong>
                            <input type="text" name="price" class="form-control" placeholder="Enter Price"
                                   value="{{ $product->price }}">
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
