<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
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

        $query = Type::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $types = $query->latest()->paginate(7)->withQueryString();

        return view('dashboard.types.index', [
            'title' => 'All Types',
            'active' => 'types',
            'types' => $types,
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
        return view('dashboard.types.create', [
            'title' => 'Create New Type',
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
            'name' => 'required|max:100',
            'slug' => 'required|max:150|unique:types',
            'category_id' => 'required'
        ]);

        Type::create($validatedData);

        return redirect('/dashboard/types')->with('success', 'New Type has been added!');
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
     * @param  \App\Models\Type  $type
     * @return \Illuminate\View\View
     */
    public function edit(Type $type)
    {
        return view('dashboard.types.edit', [
            'title' => 'Edit Type',
            'type' => $type,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Type $type)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:100',
            'slug' => 'required|max:150|unique:types,slug,' . $type->id,
            'category_id' => 'required'
        ]);

        $type->update($validatedData);

        return redirect('/dashboard/types')->with('success', 'Type has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Type $type
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return redirect('/dashboard/types')->with('success', 'Type has been deleted!');
    }

    /**
     * Get types by category
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypesByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $types = Type::where('category_id', $categoryId)->get();

        return response()->json($types);
    }
}
