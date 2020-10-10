@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">403 Forbidden</div>
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            Access denied
                        </div>
                        <a class="btn btn-primary" href="{{ redirect()->back()->getTargetUrl() }}">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
