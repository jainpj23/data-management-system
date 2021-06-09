<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


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

Route::get('/', function () {
     return redirect('/home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

   
Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::get('/userexportCsv',[UserController::class,'userexportCsv']);
    Route::resource('roles', RoleController::class);
    Route::resource('products', ProductController::class);
    Route::post('/get_category_detail',[ProductController::class,'getCategoryDetail']);
    Route::resource('category', CategoryController::class);
});
