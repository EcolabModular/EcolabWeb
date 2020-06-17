<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::resource('itemschedularies','Schedulary\ItemSchedularyApiController');
Route::resource('schedularies','Schedulary\SchedularyApiController');

$router->get('/institutions','Institution\InstitutionApiController@index');
$router->get('/laboratories','Laboratory\LaboratoryApiController@index');
$router->get('/items', 'Item\ItemApiController@index');
$router->get('/reports', 'Report\ReportApiController@index');
$router->get('/notes', 'Note\NoteApiController@index');
//Route::resource('schedularies', 'Schedulary\SchedularyApiController');
