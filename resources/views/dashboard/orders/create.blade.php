@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create New Order</h1>
    </div>
    @if (session()->has('error'))
        <div class="alert alert-danger col-lg-8" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="col-lg-8">
        <form method="POST" class="mb-5" action="/dashboard/orders" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category_id" id="category_id">
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
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" name="type_id" id="type_id">
                    <option value="">All Types</option>
                </select>
            </div>
            <div class="mb-3">
              <label for="size" class="form-label">Size</label>
              <input type="text" class="form-control @error('size') is-invalid @enderror" id="size" name="size" value="{{ old('size') }}">
              @error('size')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
                <label for="sch" class="form-label">Sch</label>
                <select class="form-select" name="sch_id">
                    <option value="">All Sches</option>
                    @foreach ($sches as $sch)
                        @if (old('sch_id') == $sch->id)
                            <option value="{{ $sch->id }}" selected>{{ $sch->sch }}</option>
                        @else
                            <option value="{{ $sch->id }}">{{ $sch->sch }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select class="form-select" name="rating_id">
                    <option value="">All Ratings</option>
                    @foreach ($ratings as $rating)
                        @if (old('rating_id') == $rating->id)
                            <option value="{{ $rating->id }}" selected>{{ $rating->rating }}</option>
                        @else
                            <option value="{{ $rating->id }}">{{ $rating->rating }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="spec" class="form-label">Spec</label>
                <select class="form-select" name="spec_id">
                    <option value="">All Specs</option>
                    @foreach ($specs as $spec)
                        @if (old('spec_id') == $spec->id)
                            <option value="{{ $spec->id }}" selected>{{ $spec->name }}</option>
                        @else
                            <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}">
                @error('date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="welding" class="form-label">Welding</label>
                <input type="text" class="form-control @error('welding') is-invalid @enderror" id="welding" name="welding" value="{{ old('welding') }}">
                @error('welding')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="penetran" class="form-label">Penetran</label>
                <input type="text" class="form-control @error('penetran') is-invalid @enderror" id="penetran" name="penetran" value="{{ old('penetran') }}">
                @error('penetran')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create Order</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var categorySelect = document.getElementById('category_id');
            var typeSelect = document.getElementById('type_id');

            categorySelect.addEventListener('change', function () {
                var selectedCategoryId = this.value;

                typeSelect.innerHTML = '<option value="">Loading...</option>';

                fetch('/types?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        typeSelect.innerHTML = '<option value="">All Types</option>';

                        data.forEach(type => {
                            var option = document.createElement('option');
                            option.value = type.id;
                            option.textContent = type.name;
                            if (type.id == "{{ old('type_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            typeSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching types:', error);
                        typeSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
            });

            var initialCategoryId = categorySelect.value;

            if (initialCategoryId) {
                categorySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
