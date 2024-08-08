@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create New Product</h1>
    </div>
    @if (session()->has('error'))
        <div class="alert alert-danger col-lg-8" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="col-lg-8">
        <form method="POST" class="mb-5" action="/dashboard/products" enctype="multipart/form-data">
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
                    <option value="">Choose Your Category First</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <select class="form-select" name="size_id" id="size_id">
                    <option value="">Choose Your Category First</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sch" class="form-label">Sch</label>
                <select class="form-select" name="sch_id" id="sch_id">
                    <option value="">Choose Your Category First</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select class="form-select" name="rating_id" id="rating_id">
                    <option value="">Choose Your Category First</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="spec" class="form-label">Spec</label>
                <select class="form-select" name="spec_id" id="spec_id">
                    <option value="">Choose Your Category First</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <select class="form-select" name="brand_id" id="brand_id">
                    <option value="">All Brands</option>
                    @foreach ($brands as $brand)
                        @if (old('brand_id') == $brand->id)
                            <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                        @else
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="price_brand" class="form-label">Price Brand</label>
                <input type="number" class="form-control @error('price_brand') is-invalid @enderror" id="price_brand" name="price_brand" value="{{ old('price_brand') }}">
                @error('price_brand')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price_id" class="form-label">Price Non-Brand</label>
                <input type="number" class="form-control @error('price_id') is-invalid @enderror" id="price_id" name="price_id" value="{{ old('price_id') }}">
                @error('price_id')
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
            var sizeSelect = document.getElementById('size_id');
            var schSelect = document.getElementById('sch_id');
            var ratingSelect = document.getElementById('rating_id');
            var specSelect = document.getElementById('spec_id');

            categorySelect.addEventListener('change', function () {
                var selectedCategoryId = this.value;

                typeSelect.innerHTML = '<option value="">Loading...</option>';
                sizeSelect.innerHTML = '<option value="">Loading...</option>';
                schSelect.innerHTML = '<option value="">Loading...</option>';
                ratingSelect.innerHTML = '<option value="">Loading...</option>';
                specSelect.innerHTML = '<option value="">Loading...</option>';

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
                fetch('/sizes?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        sizeSelect.innerHTML = '<option value="">All Sizes</option>';

                        data.forEach(size => {
                            var option = document.createElement('option');
                            option.value = size.id;
                            option.textContent = size.size;
                            if (size.id == "{{ old('size_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            sizeSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        sizeSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
                fetch('/sches?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        schSelect.innerHTML = '<option value="">All Sches</option>';

                        data.forEach(sch => {
                            var option = document.createElement('option');
                            option.value = sch.id;
                            option.textContent = sch.sch;
                            if (sch.id == "{{ old('sch_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            schSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        schSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
                fetch('/ratings?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        ratingSelect.innerHTML = '<option value="">All Ratings</option>';

                        data.forEach(rating => {
                            var option = document.createElement('option');
                            option.value = rating.id;
                            option.textContent = rating.rating;
                            if (rating.id == "{{ old('rating_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            ratingSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        ratingSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
                fetch('/specs?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        specSelect.innerHTML = '<option value="">All Specs</option>';

                        data.forEach(spec => {
                            var option = document.createElement('option');
                            option.value = spec.id;
                            option.textContent = spec.name;
                            if (spec.id == "{{ old('spec_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            specSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        specSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
            });

            var initialCategoryId = categorySelect.value;

            if (initialCategoryId) {
                categorySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
