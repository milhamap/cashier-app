@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Size</h1>
    </div>
    <a href="/dashboard/sizes" class="btn btn-success"><i class="bi bi-arrow-left"></i> Back to My Size</a>

    <div class="col-lg-8">
        <form method="POST" class="mb-5" action="/dashboard/sizes/{{ $size->id }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
              <label for="size" class="form-label">Size</label>
              <input type="text" class="form-control @error('size') is-invalid @enderror" id="size" name="size" value="{{ old('size', $size->size) }}" required autofocus>
              @error('size')
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
                        <option value="{{ $category->id }}" {{ (old('category_id', $size->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Size</button>
        </form>
    </div>
@endsection
