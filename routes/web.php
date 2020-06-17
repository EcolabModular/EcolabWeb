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

Route::get('authorization', 'Auth\LoginController@authorization')->name('authorization'); //AUTENTICACION CON TERCEROS (NO IMPLEMENTADO AUN)
//Route::fallback(function(){ return response()->view('errors.404', [], 404); }); // SOLUCION PREVIA A HANDLER, SE MOVIERON MIDDLEWARES WEB A GLOBAL EN KERNEL

Route::get('/', function () {
    return redirect('/panel');
})->middleware('auth');

// Authentication Routes...
Route::get('login', ['as' => 'login', 'uses' =>'\App\Http\Controllers\Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login', 'uses' =>'\App\Http\Controllers\Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => '\App\Http\Controllers\Auth\LoginController@logout']);

Route::group(['prefix' => 'panel','middleware' => 'auth'], function(){
    Route::get('/', function () {
        return view('bienvenida');
    })->name('welcome');

    Route::get('/estadisticas', function () {
        return view('estadisticas.indexPredictivo');
    })->name('predictivo');

    Route::get('/calendarios', function () {
        return view('Calendarios.index');
    })->name('calendarios');

    Route::resource('itemschedularies','Schedulary\ItemSchedularyApiController');
    Route::resource('itemsapi','Item\ItemApiController');

    Route::resource('schedularies','Schedulary\SchedularyController');
    Route::resource('items', 'Item\ItemController');
    Route::resource('laboratories', 'Laboratory\LaboratoryController');
    Route::resource('reports', 'Report\ReportController');
    Route::resource('users', 'User\UserController');
    Route::resource('notes', 'Note\NoteController');
    Route::resource('institutions', 'Institution\InstitutionController');

});

