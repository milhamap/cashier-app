<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Type;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardController extends Controller
{
    /**
     * Display a dashboard menu list
     *
     * @return \Illuminate\View\View
     */
    public function dashboardMenu()
    {
        $menus = Menu::all();
        return view('dashboard.index', [
            "title" => "Menu",
            "active" => "menu",
            "menus" => $menus
        ]);
    }

    /**
     * Check slug category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSlugCategory(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    /**
     * Check slug category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSlugType(Request $request)
    {
        $slug = SlugService::createSlug(Type::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    /**
     * Check slug brand
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSlugBrand(Request $request)
    {
        $slug = SlugService::createSlug(Brand::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    /**
     * Check Product Price Brand and Price ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkProduct(Request $request)
    {
        $categoryID = $request->category_id;
        $typeID = $request->type_id;
        $sizeID = $request->size_id;
        $schID = $request->sch_id;
        $ratingID = $request->rating_id;
        $specID = $request->spec_id;
        $brandID = $request->brand_id;

        $product = Product::where('category_id', $categoryID)
            ->where('type_id', $typeID)
            ->where('size_id', $sizeID)
            ->where('sch_id', $schID)
            ->where('rating_id', $ratingID)
            ->where('spec_id', $specID)
            ->where('brand_id', $brandID)
            ->first();

        return response()->json($product);
    }
}
