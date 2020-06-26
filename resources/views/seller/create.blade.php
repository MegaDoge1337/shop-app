@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <form action="{{ route('seller.store') }}" method="POST" name="add_product">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Title</strong>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title">
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Price</strong>
                                        <input type="text" name="price" class="form-control"
                                               placeholder="Enter Price">
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
        </div>
    </div>
@endsection
