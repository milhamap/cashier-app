@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Ratings</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive col-lg-8">
        <form action="/dashboard/ratings" method="GET" class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" name="category_id" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <a href="/dashboard" class="btn btn-success mb-3"><i class="bi bi-arrow-left"></i> Back to My Dashboard Menu</a>
        @if($categories->count())
            <a href="/dashboard/ratings/create" class="btn btn-primary mb-3">Create New Ratings</a>
        @else
            <a href="/dashboard/categories/create" class="btn btn-primary mb-3">Create New Category</a>
        @endif
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Rating</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($ratings as $rating)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rating->rating }}</td>
                    <td>
                        <a href="/dashboard/ratings/{{ $rating->id }}/edit" class="badge bg-warning">
                            <i class="bi bi-pencil-square" style="font-size:1rem;"></i>
                        </a>
                        <form action="/dashboard/ratings/{{ $rating->id}}" method="POST" class="d-inline">
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
    <div class="mt-3">
        {{ $ratings->links('dashboard.layouts.pagination') }}
    </div>
@endsection
