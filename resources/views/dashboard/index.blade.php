@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome back, {{ auth()->user()->name }}</h1>
    </div>
    <div class="row">
        @foreach($menus as $menu)
            <a href="/dashboard/{{$menu->url}}" class="col-3 justify-content-center text-center fs-5 my-2 text-decoration-none text-white">
                <div class="{{$menu->background_color}} p-5 rounded" style="--bs-bg-opacity: .9;">
                    <p>{{$menu->name}}</p>
                </div>
            </a>
        @endforeach
    </div>
@endsection
