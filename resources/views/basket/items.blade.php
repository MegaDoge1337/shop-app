@extends('layouts.me')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="laravel_crud">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($basket as $content)
                            <tr>
                                <td>{{ $content->title }}</td>
                                <td>{{ $content->price }}</td>
                                <td>{{ date('Y-m-d', strtotime($content->created_at)) }}</td>
                                <td>{{ date('Y-m-d', strtotime($content->updated_at)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
