<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sch;
use Illuminate\Http\Request;

class SchController extends Controller
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

        $query = Sch::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $sches = $query->latest()->paginate(7)->withQueryString();

        return view('dashboard.sches.index', [
            'title' => 'All SCH',
            'active' => 'sch',
            'sches' => $sches,
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
        return view('dashboard.sches.create', [
            'title' => 'Create New SCH',
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
            'sch' => 'required',
            'category_id' => 'required'
        ]);

        Sch::create($validatedData);

        return redirect('/dashboard/sches')->with('success', 'New SCH has been added!');
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
     * @param  \App\Models\Sch  $sch
     * @return \Illuminate\View\View
     */
    public function edit(Sch $sch)
    {
        return view('dashboard.sches.edit', [
            'title' => 'Edit SCH',
            'sch' => $sch,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Sch $sch, Request $request)
    {
        $validatedData = $request->validate([
            'sch' => 'required',
            'category_id' => 'required'
        ]);

        $sch->update($validatedData);

        return redirect('/dashboard/sches')->with('success', 'SCH has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sch  $sch
     */
    public function destroy(Sch $sch)
    {
        $sch->delete();
        return redirect('/dashboard/sches')->with('success', 'SCH has been deleted!');
    }

    /**
     * Get all SCH by category
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchesByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $sches = Sch::where('category_id', $categoryId)->get();

        return response()->json($sches);
    }
}
