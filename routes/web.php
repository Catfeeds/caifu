<?php


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
    return view('welcome');
});

Route::group(['prefix' => '/statistic/kpi-target'], function() {
    Route::get('/index','\App\Statistic\Controllers\KpiTargetController@index');
    Route::post('/edit','\App\Statistic\Controllers\KpiTargetController@edit');
});

Route::group(['prefix' => '/statistic/api'], function() {
    Route::post('/get-organize','\App\Statistic\Controllers\ApiController@getOrganize');
});
Route::get('/statistic/order/index','\App\Statistic\Controllers\OrderController@index');

Route::any('/statistic/user-cooperative/index','\App\Statistic\Controllers\UserCooperativeController@index');