@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Product</div>

                    <div class="card-body">
                        <form action="{{ route('seller.update', $product->id) }}" method="POST" name="update_product">
                            {{ csrf_field() }}
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Title</strong>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                               value="{{ $product->profile->title }}">
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
                                    <div class="form-group">
                                        <strong>Description</strong>
                                        <input type="text" name="description" class="form-control"
                                               placeholder="Enter Description" value="{{ $product->profile->description }}">
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Image URL</strong>
                                        <input type="text" name="image_url" class="form-control"
                                               placeholder="Enter Image URL" value="{{ $product->profile->imageUrl }}">
                                        <span class="text-danger">{{ $errors->first('image_url') }}</span>
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
        </div>
    </div>
    </div>
@endsection
