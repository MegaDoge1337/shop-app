@extends('layouts.me')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="list-group">
                            <a href="{{ route('home.contacts') }}" class="list-group-item list-group-item-action">Edit contacts information</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
