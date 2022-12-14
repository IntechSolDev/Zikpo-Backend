<?php

use App\Http\Controllers\Web\Biocircle\BioCategoryController;
use App\Http\Controllers\Web\Biocircle\BioProductController;
use App\Http\Controllers\Web\Biocircle\BioSubCategoryController;
use App\Http\Controllers\Web\Customer\CartController;
use App\Http\Controllers\Web\Customer\CategoryController;
use App\Http\Controllers\Web\Customer\ProductController;
use App\Http\Controllers\Web\Customer\SubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LoginController;
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
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/admin');
});


Route::group(['middleware' => ['auth']], function () {

});
