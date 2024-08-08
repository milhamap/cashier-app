<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.products.index', [
            'title' => 'All Products',
            'active' => 'products',
            'products' => Product::latest()->paginate(7)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.products.create', [
            'title' => 'Create New Product',
            'categories' => Category::where('user_id', auth()->user()->id)->get(),
            'brands' => Brand::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'type_id' => 'required',
            'size_id' => 'nullable',
            'sch_id' => 'nullable',
            'rating_id' => 'nullable',
            'spec_id' => 'nullable',
            'brand_id' => 'nullable',
            'price_brand' => 'nullable',
            'price_id' => 'nullable',
            'welding' => 'nullable',
            'penetran' => 'nullable'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Product::create($validatedData);

        return redirect('/dashboard/products')->with('success', 'Product has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        $product->load('category', 'type', 'size', 'sch', 'rating', 'spec', 'brand');

        return response()->json([
            'status' => 'success',
            'message' => 'Product detail',
            'data' => $product
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
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $invoiceItems = InvoiceItem::where('product_id', $product->id)->get();

        $invoiceItems->each(function ($item) {
            $invoice = Invoice::where('id', $item->invoice_id)->get();
            $invoice->amount -= $item->total;
            $item->delete();
            if ($invoice->amount == 0) {
                $invoice->delete();
            }
        });
        $product->delete();

        return redirect('/dashboard/products')->with('success', 'Product has been deleted!');
    }
}
