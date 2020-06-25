@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if(session('scs_message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('scs_message') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">Edit Contacts Information</div>

                    <div class="card-body">
                        <form action="{{ route('contacts.update', $user->id) }}" method="post" name="update_user">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <strong>Phone Number</strong>
                                                <input type="text" name="phone_number" class="form-control"
                                                       placeholder="Enter Phone Number"
                                                       value="{{ $user->phone_number }}">
                                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <strong>Address</strong>
                                                <input class="form-control" col="4" name="address"
                                                       placeholder="Enter Address"
                                                       value="{{ $user->address }}">
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
