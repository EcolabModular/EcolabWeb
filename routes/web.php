<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'WelcomeController@showWelcomePage')->name('welcome');

Route::get('/admin', function () {
    return view('bienvenida');
})->name('panel')->middleware('auth');

// Authentication Routes...
Route::get('login', ['as' => 'login', 'uses' =>'\App\Http\Controllers\Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login', 'uses' =>'\App\Http\Controllers\Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => '\App\Http\Controllers\Auth\LoginController@logout']);

Route::group(['prefix' => 'admin'], function(){
    Route::resource('items', 'Item\ItemController')->middleware('auth');
    Route::resource('schedularies', 'Schedulary\SchedularyController')->middleware('auth');
    Route::resource('laboratories', 'Laboratory\LaboratoryController')->middleware('auth');
    Route::resource('reports', 'Report\ReportController')->middleware('auth');
    Route::resource('users', 'User\UserController')->middleware('auth');
	//Route::resource('categories.dishes', 'Category\CategoryDishController')->middleware('auth');
	//Route::resource('categories.galleries', 'Category\CategoryGalleryController')->middleware('auth');

});
