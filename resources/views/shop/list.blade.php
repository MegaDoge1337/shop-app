@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Shops List</div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($sellers as $seller)
                                <a href="{{ route('shop.show', $seller->id) }}"
                                   class="list-group-item list-group-item-action">{{ $seller->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
