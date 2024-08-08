@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Products</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive col-lg-12">
        <a href="/dashboard" class="btn btn-success mb-3"><i class="bi bi-arrow-left"></i> Back to My Dashboard Menu</a>
        <a href="/dashboard/products/create" class="btn btn-primary mb-3">Create New Product</a>
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category</th>
                <th scope="col">Type</th>
                <th scope="col">Size</th>
                <th scope="col">Sch</th>
                <th scope="col">Rating</th>
                <th scope="col">Spec</th>
                <th scope="col">Price Brand</th>
                <th scope="col">Price Non-Brand</th>
                <th scope="col">Welding</th>
                <th scope="col">Penetran</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->type->name }}</td>
                    <td>{{ $product->size->size ?? '' }}</td>
                    <td>{{ $product->sch ? $product->sch->sch : '' }}</td>
                    <td>{{ $product->rating ? $product->rating->rating : '' }}</td>
                    <td>{{ $product->spec ? $product->spec->name : '' }}</td>
                    <td>Rp. {{ number_format($product->price_brand, 2, ',', '.') }}</td>
                    <td>Rp. {{ number_format($product->price_id, 2, ',', '.') }}</td>
                    <td>{{ $product->welding }}</td>
                    <td>{{ $product->penetran }}</td>
                    <td>
                        <a href="/dashboard/products/{{ $product->id }}/edit" class="badge bg-warning">
                            <i class="bi bi-pencil-square" style="font-size:1rem;"></i>
                        </a>
                        <form action="/dashboard/products/{{ $product->id}}" method="POST" class="d-inline">
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
        {{ $products->links('dashboard.layouts.pagination') }}
    </div>
@endsection
