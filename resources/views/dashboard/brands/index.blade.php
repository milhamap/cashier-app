@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Brands</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive col-lg-8">
        <a href="/dashboard" class="btn btn-success mb-3"><i class="bi bi-arrow-left"></i> Back to My Dashboard Menu</a>
        <a href="/dashboard/brands/create" class="btn btn-primary mb-3">Create New Brand</a>
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>
                        <a href="/dashboard/brands/{{ $brand->slug }}/edit" class="badge bg-warning">
                            <i class="bi bi-pencil-square" style="font-size:1rem;"></i>
                        </a>
                        <form action="/dashboard/brands/{{ $brand->slug}}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="badge bg-danger border-0" onclick="return confirm('Are You Sure?')">
                                <i class="bi bi-x-circle" style="font-size:1rem;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
