@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="laravel_crud">
                        <div class="list-group">
                            @foreach($shops as $shop)
                                <a href="{{ route('shop.show', $shop->id) }}" class="list-group-item list-group-item-action">{{ $shop->name }}</a>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
