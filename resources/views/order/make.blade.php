@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <form action="{{ route('order.store') }}" method="POST" name="define_address">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Address</strong>
                                        <input type="text" name="address" class="form-control" placeholder="Enter Address">
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>
                                </div>
                                <input type="hidden" name="seller_id" value="{{ $seller_id }}">
                                <input type="hidden" name="customer_id" value="{{ $customer_id }}">
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
