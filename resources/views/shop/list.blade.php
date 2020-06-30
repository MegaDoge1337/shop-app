@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Shops List</div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($shops as $shop)
                                <a href="{{ route('shop.show', $shop->id) }}"
                                   class="list-group-item list-group-item-action">{{ $shop->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
