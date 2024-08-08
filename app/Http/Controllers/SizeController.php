<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');

        $query = Size::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $sizes = $query->latest()->paginate(7)->withQueryString();

        return view('dashboard.sizes.index', [
            'title' => 'All Sizes',
            'active' => 'sizes',
            'sizes' => $sizes,
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.sizes.create', [
            'title' => 'Create New Size',
            'categories' => Category::all()
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
        $validatedData = $request->validate([
            'size' => 'required',
            'category_id' => 'required'
        ]);

        Size::create($validatedData);

        return redirect('/dashboard/sizes')->with('success', 'Size created successfully.');
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
     * @param \App\Models\Size $size
     * @return \Illuminate\View\View
     */
    public function edit(Size $size)
    {
        return view('dashboard.sizes.edit', [
            'title' => 'Edit Size',
            'size' => $size,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Size $size
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Size $size)
    {
        $validatedData = $request->validate([
            'size' => 'required',
            'category_id' => 'required'
        ]);

        $size->update($validatedData);

        return redirect('/dashboard/sizes')->with('success', 'Size updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Size $size
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Size $size)
    {
        $size->delete();

        return redirect('/dashboard/sizes')->with('success', 'Size deleted successfully.');
    }

    /**
     * Get sizes by category
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSizesByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $sizes = Size::where('category_id', $categoryId)->get();

        return response()->json($sizes);
    }
}
