<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\Cms;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Routes - Main Website
Route::get('/', [Home::class, 'index']);
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/products', [Home::class, 'products']);
Route::get('/cart', [Home::class, 'cart'])->name('cart');
Route::post('/addtocart/{fid}', [Home::class, 'addtocart'])->name('addtocart');
Route::post('/updatecart', [Home::class, 'updatecart'])->name('updatecart');
Route::post('/deletecartitem', [Home::class, 'deletecartitem'])->name('deletecartitem');
// Route::get('/details/{fid}', [Home::class, 'details']);
Route::get('/checkout', [Home::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('/checkout', [Home::class, 'createOrder']);
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login'); // customer user
Route::post('/search-fruits', [Home::class, 'searchFruits']);
Route::get('/orderdetails/{oid}', [Home::class, 'orderDetails']);
Route::get('/orders', [Home::class, 'orders']);

// Routes - Admin Website
Route::get('/cms', [Cms::class, 'dashboard']);
Route::get('/cms', [Cms::class, 'dashboard'])->name('cms/dashboard');
Route::get('/cms/dashboard', [Cms::class, 'dashboard'])->name('cms/dashboard');
Route::get('/cms/login', [Cms::class, 'showLoginForm'])->name('cms/login');
Route::post('cms/login', [Cms::class, 'login'])->name('cms.login');
Route::get('/cms/fruit-types', [Cms::class, 'fruitTypes'])->name('cms/fruit-types');
Route::post('cms/addfruittype', [Cms::class, 'addFruitType']);
Route::post('cms/updatefruittype', [Cms::class, 'editFruitType']);
Route::post('cms/deletefruittype', [Cms::class, 'deleteFruitType']);
Route::get('/cms/fruits', [Cms::class, 'fruits']);
Route::get('/cms/addfruit', [Cms::class, 'addFruit']);
Route::post('/cms/addfruit', [Cms::class, 'addNewFruit']);
Route::get('/cms/editfruit/{fid}', [Cms::class, 'editFruit']);
Route::post('/cms/editfruit/{fid}', [Cms::class, 'editFruit']);
Route::post('cms/deletefruit', [Cms::class, 'deleteFruit']);
Route::get('/cms/users', [Cms::class, 'users']);
Route::get('/cms/orders', [Cms::class, 'orders']);
Route::get('/cms/orderdetails/{oid}', [Cms::class, 'orderDetails'])->name('cms/orderdetails');

//Routes - Others
Route::get('/{fruit}', [Home::class, 'details'])
    ->where('fruit', '^(?!(login|register|home)$).*$'); //catch-all route for product details page
    
Route::get('/versions', [Home::class, 'versions']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
