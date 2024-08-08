<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.transactions.index', [
            'title' => 'All Transactions',
            'transactions' => Invoice::latest()->paginate(7)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $categoryId = $request->category_id;
        $typeId = $request->type_id;
        $sizeId = $request->size_id;
        $schId = $request->sch_id;
        $ratingId = $request->rating_id;
        $specId = $request->spec_id;
        $brandId = $request->brand_id;

        $query = Product::query();

        if ($categoryId)
            $query->where('category_id', $categoryId);

        if ($typeId)
            $query->where('type_id', $typeId);

        if ($sizeId)
            $query->where('size_id', $sizeId);

        if ($schId)
            $query->where('sch_id', $schId);

        if ($ratingId)
            $query->where('rating_id', $ratingId);

        if ($specId)
            $query->where('spec_id', $specId);

        if ($brandId)
            $query->where('brand_id', $brandId);

        $products = $query->latest()->paginate(7)->withQueryString();

        $now = time();

        $identifier = 'TRX-' . $now;

        return view('dashboard.transactions.create', [
            'title' => 'Create New Transaction',
            'categories' => Category::where('user_id', auth()->user()->id)->get(),
            'brands' => Brand::all(),
            'products' => $products,
            'identifier' => $identifier
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'total' => 'required|array',
            'code' => 'required',
            'amount' => 'required',
        ];

        $validatedData = $request->validate($rules);

        $invoice = Invoice::create([
            'user_id' => auth()->user()->id,
            'code' => $validatedData['code'],
            'amount' => $validatedData['amount'],
        ]);

        foreach ($validatedData['product_id'] as $key => $product_id) {
            $invoiceItem = new InvoiceItem([
                'product_id' => $product_id,
                'quantity' => $validatedData['quantity'][$key],
                'total' => $validatedData['total'][$key],
            ]);
            $invoice->items()->save($invoiceItem); // Save each item associated with the invoice
        }

        return redirect('/dashboard/transactions')->with('success', 'Transaction has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        return view('dashboard.transactions.show', [
            'title' => 'Transaction Detail',
            'transactions' => Invoice::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(string $id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->items()->delete(); // Delete all items associated with the invoice
            $invoice->delete(); // Delete the invoice

            return redirect('/dashboard/transactions')->with('success', 'Transaction has been deleted!');
        } catch (\Exception $e) {
            // Tangkap dan cetak informasi error
            Log::error('Error occurred: ' . $e->getMessage());
            dd($e); // Cetak detail error untuk tracing
        }
    }
}
