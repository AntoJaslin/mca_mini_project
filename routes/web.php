<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;

use App\Http\Controllers\Frontend\HomePageController;

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

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [HomePageController::class, 'showHomePage']);
Route::get('/cart', [HomePageController::class, 'showCartPage']);
Route::get('/my_orders', [HomePageController::class, 'showMyOrdersPage']);
Route::post('/add-cart', [HomePageController::class, 'addCart']);
Route::post('/create-order', [HomePageController::class, 'createOrder']);


Route::get('/user-signup', function () {
    return view('app.signup');
})->name('user-signup');
Route::post('/user-signup', [HomePageController::class, 'registerUser'])->name("signupUser");

Route::get('/user-login', function () {
    return view('app.login');
})->name('user-login');
Route::post('/user-login', [HomePageController::class, 'loginUser'])->name("signinUser");
Route::get('/user-logout', [HomePageController::class, 'logoutUser'])->name("user-logout");

Route::get('/lost-password', function () {
    return view('app.forgot-password');
})->name('lost-password');
Route::get('/reset-password', function () {
    return view('app.reset-password');
})->name('reset-password');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('users', UsersController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('products', ProductsController::class);
Route::resource('orders', OrdersController::class);
// Route::get('/products/create', function () {
//     return view('admin.products.create');
// })->middleware(['auth']);
//Route::get('/products/edit/{id}', ProductsController::class, 'edit')->middleware(['auth']);
require __DIR__.'/auth.php';
