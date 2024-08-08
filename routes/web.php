<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SchController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SpecController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home', [
        "title" => "Home",
        "active" => "home"
    ]);
});

Route::get('/login', [StaticController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/register', [StaticController::class, 'register'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'dashboardMenu'])->middleware('auth');
Route::get('/dashboard/categories/check-slug', [DashboardController::class, 'checkSlugCategory'])->middleware('auth');
Route::get('/dashboard/types/check-slug', [DashboardController::class, 'checkSlugType'])->middleware('auth');
Route::get('/dashboard/brands/check-slug', [DashboardController::class, 'checkSlugBrand'])->middleware('auth');
Route::get('/dashboard/brands/check-slug', [DashboardController::class, 'checkSlugBrand'])->middleware('auth');
Route::get('/dashboard/check-product', [DashboardController::class, 'checkProduct'])->middleware('auth');

Route::get('/types', [TypeController::class, 'getTypesByCategory']);
Route::get('/sches', [SchController::class, 'getSchesByCategory']);
Route::get('/ratings', [RatingController::class, 'getRatingsByCategory']);
Route::get('/ratings', [RatingController::class, 'getRatingsByCategory']);
Route::get('/sizes', [SizeController::class, 'getSizesByCategory']);
Route::get('/specs', [SpecController::class, 'getSpecsByCategory']);

Route::resource('/dashboard/categories',CategoryController::class)->middleware('auth');
Route::resource('/dashboard/types',TypeController::class)->middleware('auth');
Route::resource('/dashboard/sches',SchController::class)->middleware('auth');
Route::resource('/dashboard/ratings',RatingController::class)->middleware('auth');
Route::resource('/dashboard/specs',SpecController::class)->middleware('auth');
Route::resource('/dashboard/sizes',SizeController::class)->middleware('auth');
Route::resource('/dashboard/brands',BrandController::class)->middleware('auth');
Route::resource('/dashboard/products',ProductController::class)->middleware('auth');
Route::resource('/dashboard/transactions',TransactionController::class)->middleware('auth');
