@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create New Rating</h1>
    </div>
    <a href="/dashboard/ratings" class="btn btn-success"><i class="bi bi-arrow-left"></i> Back to My Rating</a>

    <div class="col-lg-8">
        <form method="POST" class="mb-5" action="/dashboard/ratings" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="rating" class="form-label">Rating</label>
              <input type="text" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating') }}" required autofocus>
              @error('rating')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category_id">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        @if (old('category_id') == $category->id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Rating</button>
        </form>
    </div>
@endsection
