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
    Route::post('/import','\App\Statistic\Controllers\KpiTargetController@import');

});

Route::group(['prefix' => '/statistic/api'], function() {
    Route::post('/get-organize','\App\Statistic\Controllers\ApiController@getOrganize');
});
Route::get('/statistic/order/index','\App\Statistic\Controllers\OrderController@index');
Route::post('/statistic/order/edit-organize','\App\Statistic\Controllers\OrderController@editOrganize');


Route::any('/statistic/user-cooperative/index','\App\Statistic\Controllers\UserCooperativeController@index');

Route::any('/statistic/user-cooperative/reset','\App\Statistic\Controllers\UserCooperativeController@reset');

Route::get('/statistic/ribao/index','\App\Statistic\Controllers\RibaoController@index');
Route::post('/statistic/ribao/reset','\App\Statistic\Controllers\RibaoController@reset');


Route::post('/statistic/api/get-stat-daily','\App\Statistic\Controllers\ApiController@getStatDaily');


Route::get('/statistic/area-user/index','\App\Statistic\Controllers\AreaUserController@index');

Route::group(['prefix' => '/statistic/user-add'], function() {
    Route::get('/index','\App\Statistic\Controllers\UserAddController@index');
    Route::post('/search','\App\Statistic\Controllers\UserAddController@searchUserChart');
    Route::any('/reset','\App\Statistic\Controllers\UserAddController@reset');

});

Route::group(['prefix' => '/statistic/cooperative'], function() {
    Route::get('/index','\App\Statistic\Controllers\CooperativeController@index');
    Route::get('/reset','\App\Statistic\Controllers\CooperativeController@reset');
});


    Route::get('/statistic/kpi-complete/index','\App\Statistic\Controllers\KpiCompleteController@index');
    Route::get('/statistic/kpi-contribution/index','\App\Statistic\Controllers\KpiContributionController@index');

