<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Spec;
use Illuminate\Http\Request;

class SpecController extends Controller
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

        $query = Spec::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $specs = $query->latest()->paginate(7)->withQueryString();

        return view('dashboard.specs.index', [
            'title' => 'All Specs',
            'active' => 'specs',
            'specs' => $specs,
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
        return view('dashboard.specs.create', [
            'title' => 'Create New Spec',
            'categories' => Category::all()
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
            'name' => 'required',
            'category_id' => 'required'
        ]);

        Spec::create($validatedData);

        return redirect('/dashboard/specs')->with('success', 'New Spec has been added!');
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
     * @param \App\Models\Spec $spec
     * @return \Illuminate\View\View
     */
    public function edit(Spec $spec)
    {
        return view('dashboard.specs.edit', [
            'title' => 'Edit Spec',
            'spec' => $spec,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Spec $spec
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Spec $spec)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'category_id' => 'required'
        ]);

        $spec->update($validatedData);

        return redirect('/dashboard/specs')->with('success', 'Spec has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Spec $spec
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Spec $spec)
    {
        $spec->delete();
        return redirect('/dashboard/specs')->with('success', 'Spec has been deleted!');
    }

    /**
     * Get specs by category
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpecsByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $specs = Spec::where('category_id', $categoryId)->get();

        return response()->json($specs);
    }
}
