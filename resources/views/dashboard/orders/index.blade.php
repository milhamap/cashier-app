@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Orders</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive col-lg-12">
        <a href="/dashboard" class="btn btn-success mb-3"><i class="bi bi-arrow-left"></i> Back to My Dashboard Menu</a>
        <a href="/dashboard/orders/create" class="btn btn-primary mb-3">Create New Orders</a>
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
                <th scope="col">Date</th>
                <th scope="col">Price</th>
                <th scope="col">Welding</th>
                <th scope="col">Penetran</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->category->name }}</td>
                    <td>{{ $order->type->name }}</td>
                    @if($order->type->size_type == 'string')
                        <td>{{ $order->size_string }}</td>
                    @else
                        <td>{{ $order->size }}</td>
                    @endif
                    <td>{{ $order->sch ? $order->sch->sch : '' }}</td>
                    <td>{{ $order->rating ? $order->rating->rating : '' }}</td>
                    <td>{{ $order->spec ? $order->spec->name : '' }}</td>
                    <td>{{ $order->date }}</td>
                    <td>Rp. {{ number_format($order->price, 2, ',', '.') }}</td>
                    <td>{{ $order->welding }}</td>
                    <td>{{ $order->penetran }}</td>
                    <td>
                        <a href="/dashboard/orders/{{ $order->id }}/edit" class="badge bg-warning">
                            <i class="bi bi-pencil-square" style="font-size:1rem;"></i>
                        </a>
                        <form action="/dashboard/orders/{{ $order->id}}" method="POST" class="d-inline">
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
        {{ $orders->links('dashboard.layouts.pagination') }}
    </div>
@endsection
