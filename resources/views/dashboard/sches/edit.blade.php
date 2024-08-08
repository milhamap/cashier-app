@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit SCH</h1>
    </div>
    <a href="/dashboard/sches" class="btn btn-success"><i class="bi bi-arrow-left"></i> Back to My SCH</a>

    <div class="col-lg-8">
        <form method="POST" class="mb-5" action="/dashboard/sches/{{ $sch->id }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="sch" class="form-label">Sch</label>
                <input type="text" class="form-control @error('sch') is-invalid @enderror" id="sch" name="sch" value="{{ old('sch', $sch->sch) }}" required autofocus>
                @error('sch')
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
                        <option value="{{ $category->id }}" {{ (old('category_id', $type->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Sch</button>
        </form>
    </div>
@endsection
