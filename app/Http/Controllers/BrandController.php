<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('dashboard.brands.index', [
            "title" => "All Brands",
            "active" => "brands",
            "brands" => Brand::latest()->paginate(7)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.brands.create', [
            "title" => "Create New Brand"
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
            'name' => 'required|max:100',
            'slug' => 'required|max:200|unique:brands',
        ]);

        Brand::create($validatedData);

        return redirect('/dashboard/brands')->with('success', 'New Brand has been added!');
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Brand $brand)
    {
        return view('dashboard.brands.edit', [
            "title" => "Edit Brand",
            "brand" => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Brand $brand)
    {
        $rules = [
            'name' => 'required|max:100'
        ];

        if($request->slug != $brand->slug)
            $rules['slug'] = 'required|max:150|unique:brands';

        $validatedData = $request->validate($rules);

        $brand->update($validatedData);

        return redirect('/dashboard/brands')->with('success', 'Brand has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect('/dashboard/brands')->with('success', 'Brand has been deleted!');
    }
}
