@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Transaction</h1>
    </div>
    <a href="/dashboard/transactions" class="btn btn-success mb-3"><i class="bi bi-arrow-left"></i> Back to My Transaction</a>
    <div class="accordion" id="accordionDetail">
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $transactions->id }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $transactions->id }}" aria-expanded="false" aria-controls="collapse{{ $transactions->id }}">
                    {{ $transactions->code }} - Rp. {{ number_format($transactions->amount, 2, ',', '.') }}
                </button>
            </h2>
            <div id="collapse{{ $transactions->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $transactions->id }}" data-bs-parent="#accordionDetail">
                <div class="accordion-body">
                    <p><strong>Transaction Code:</strong> {{ $transactions->code }}</p>
                    <p><strong>Transaction Amount:</strong> Rp. {{ number_format($transactions->amount, 2, ',', '.') }}</p>
                    <p><strong>User:</strong> {{ $transactions->user->name }}</p>
                    <p><strong>Created At:</strong> {{ $transactions->created_at->format('Y-m-d H:i:s') }}</p>
                    <hr>
                    <h5>Products:</h5>
                    <ul>
                        @foreach ($transactions->items as $item)
                            <li>
                                <strong>Category:</strong> {{ $item->product->category->name ?? '' }} <br>
                                <strong>Type:</strong> {{ $item->product->type->name ?? '' }} <br>
                                <strong>Size:</strong> {{ $item->product->size->size ?? '' }} <br>
                                <strong>Sch:</strong> {{ $item->product->sch ? $item->product->sch->sch : '' }} <br>
                                <strong>Rating:</strong> {{ $item->product->rating ? $item->product->rating->rating : '' }} <br>
                                <strong>Spec:</strong> {{ $item->product->spec ? $item->product->spec->name : '' }} <br>
                                <strong>Welding:</strong> {{ $item->product->welding ?? '' }} <br>
                                <strong>Penetran:</strong> {{ $item->product->penetran ?? '' }} <br>
                                <strong>Price Non-Brand:</strong> {{$item->product->price_id ? 'Rp. ' . number_format($item->product->price_id, 2, ',', '.') : ''}} <br>
                                <strong>Price Brand:</strong> {{$item->product->price_brand ? 'Rp. ' . number_format($item->product->price_brand, 2, ',', '.') : ''}} <br>
                                <strong>Quantity:</strong> {{ $item->quantity }} <br>
                                <strong>Total:</strong> Rp. {{ number_format($item->total, 2, ',', '.') }}
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
