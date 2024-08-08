<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Sch;
use App\Models\Spec;
use App\Models\Type;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.orders.index', [
            'title' => 'All Orders',
            'active' => 'orders',
            'orders' => Order::latest()->paginate(7)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.orders.create', [
            'categories' => Category::where('user_id', auth()->user()->id)->get(),
            'sches' => Sch::all(),
            'ratings' => Rating::all(),
            'specs' => Spec::all(),
            'title' => 'Create New Order'
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
            'sch_id' => 'nullable',
            'rating_id' => 'nullable',
            'spec_id' => 'required',
            'date' => 'nullable',
            'price' => 'nullable',
            'welding' => 'nullable',
            'penetran' => 'nullable',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $type = Type::find($validatedData['type_id']);
        if ($type->size_type == 'string') {
            $validatedData['size_string'] = $request->size;
        } else {
            $validatedData['size'] = $request->size;
        }

        Order::create($validatedData);

        return redirect('/dashboard/orders')->with('success', 'New Order has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        return view('dashboard.orders.edit', [
            'title' => 'Edit Order',
            'order' => $order,
            'categories' => Category::where('user_id', auth()->user()->id)->get(),
            'sches' => Sch::all(),
            'ratings' => Rating::all(),
            'specs' => Spec::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'type_id' => 'required',
            'sch_id' => 'nullable',
            'rating_id' => 'nullable',
            'spec_id' => 'required',
            'date' => 'nullable',
            'price' => 'nullable',
            'welding' => 'nullable',
            'penetran' => 'nullable',
        ]);

        $type = Type::find($validatedData['type_id']);
        if ($type->size_type == 'string') {
            $validatedData['size_string'] = $request->size;
        } else {
            $validatedData['size'] = $request->size;
        }

        $order->update($validatedData);

        return redirect('/dashboard/orders')->with('success', 'Order has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect('/dashboard/orders')->with('success', 'Order has been deleted!');
    }
}
