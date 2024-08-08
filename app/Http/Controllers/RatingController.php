<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
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

        $query = Rating::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $ratings = $query->latest()->paginate(7)->withQueryString();

        return view('dashboard.ratings.index', [
            'title' => 'All Ratings',
            'active' => 'ratings',
            'ratings' => $ratings,
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
        return view('dashboard.ratings.create', [
            'title' => 'Create New Rating',
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
            'rating' => 'required',
            'category_id' => 'required'
        ]);

        Rating::create($validatedData);

        return redirect('/dashboard/ratings')->with('success', 'New Rating has been added!');
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
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\View\View
     */
    public function edit(Rating $rating)
    {
        return view('dashboard.ratings.edit', [
            'title' => 'Edit Rating',
            'rating' => $rating,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Rating $rating)
    {
        $validatedData = $request->validate([
            'rating' => 'required',
            'category_id' => 'required'
        ]);

        $rating->update($validatedData);

        return redirect('/dashboard/ratings')->with('success', 'Rating has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect('/dashboard/ratings')->with('success', 'Rating has been deleted!');
    }

    /**
     * Get ratings by category
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRatingsByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $ratings = Rating::where('category_id', $categoryId)->get();

        return response()->json($ratings);
    }
}
